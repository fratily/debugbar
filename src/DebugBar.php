<?php
/**
 * FratilyPHP Debug
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @author      Kento Oka <kento.oka@kentoka.com>
 * @copyright   (c) Kento Oka
 * @license     MIT
 * @since       1.0.0
 */
namespace Fratily\DebugBar;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

/**
 *
 */
class DebugBar{

    /**
     * @var Collector\CollectorInterface[]
     */
    private $collectors;

    /**
     * @var Panel\PanelInterface[]
     */
    private $panels;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * 値がコレクターインスタンスか確認する
     *
     * @param   mixed   $val
     *
     * @return  bool
     */
    protected static function isCollector($val){
        return $val instanceof Collector\CollectorInterface;
    }

    /**
     * 値がパネルクラスか確認する
     *
     * @param   string  $class
     *
     * @return  bool
     */
    protected static function isPanelClass(string $class){
        static $result  = [];

        if(!array_key_exists($class, $result)){
            $result[$class] = false;

            if(class_exists($class)
                && in_array(Panel\PanelInterface::class, class_implements($class))
            ){
                $result[$class] = true;
            }
        }

        return $result[$class];
    }

    /**
     * Constructor
     *
     * @param   Collector\CollectorInterface[]  $collectors
     */
    public function __construct(array $collectors = []){
        $collectors = array_unique(
            array_filter($collectors, [self::class, "isCollector"])
        );

        $this->collectors   = [];
        $this->panels       = [];

        foreach($collectors as $name => $collector){
            $this->addCollector($name, $collector);
        }
    }

    /**
     * コレクターを取得する
     *
     * @param   string  $name
     *
     * @return  Collector\CollectorInterface|null
     */
    public function getCollector(string $name){
        return $this->collectors[$name] ?? null;
    }

    /**
     * コレクターリストを取得する
     *
     * @return  CollectorInterface[]
     */
    public function getCollectors(){
        return $this->collectors;
    }

    /**
     * 指定した名前のコレクターが登録されているか確認する
     *
     * @param   string  $name
     *
     * @return  bool
     */
    public function hasCollector(string $name){
        return array_key_exists($name, $this->collectors);
    }

    /**
     * コレクターを登録する
     *
     * @param   Collector\CollectorInterface    $collector
     *
     * @return  $this
     *
     * @throws  \LogicException
     * @throws  \InvalidArgumentException
     */
    public function addCollector(string $name, Collector\CollectorInterface $collector){
        if($name === ""){
            throw new \LogicException;  // 名前が空のコレクターは実装してはならない
        }

        if($this->hasCollector($name)){
            throw new \InvalidArgumentException();  // 同名のコレクターは使用できない
        }

        $collector->setName($name);

        $this->collectors[$name]    = $collector;

        return $this;
    }

    /**
     * 指定したHTML文章にデバッグバーを埋め込む
     *
     * @param   string  $src
     *
     * @return  string
     */
    public function embed(string $src){
        if(strtolower(substr($src, 0, 14)) !== "<!doctype html"){
            return $src;
        }

        $src        = $this->getDomDocument($src);
        $debug      = $this->getDomDocument($this->generateDebugHtml());
        $srcPath    = new \DOMXPath($src);
        $debugPath  = new \DOMXPath($debug);

        $headNode   = $srcPath->query("//head")->item(0);
        $bodyNode   = $srcPath->query("//body")->item(0);

        if($headNode !== null && $bodyNode !== null){
            $headNode->appendChild($src->importNode($debugPath->query("//head/style")->item(0), true));
            $bodyNode->appendChild($src->importNode($debugPath->query("//body/div")->item(0), true));
            $bodyNode->appendChild($src->importNode($debugPath->query("//body/script")->item(0), true));
        }

        return $src->saveHTML();
    }

    /**
     * デバッグバー用のHTMLを返す
     *
     * @return  string
     */
    private function generateDebugHtml(){
        $this->initTwig();

        return $this->twig->render("debugbar.twig", [
            "collectors"    => $this->collectors
        ]);
    }

    /**
     * 文字列からDOMDocumentインスタンスを生成する
     *
     * @param   string  $src
     *
     * @return  \DOMDocument|null
     *  渡された文字列がhtml5文章でないならnullを返す
     */
    private function getDomDocument(string $src){
        if(strtolower(substr($src, 0, 14)) !== "<!doctype html"){
            return null;
        }

        $dom    = new \DOMDocument();
        @$dom->loadHTML($src);

        return $dom;
    }

    /**
     * デバッグバー用のTwigを初期化する
     *
     * @return  void
     */
    private function initTwig(){
        if($this->twig === null){
            $this->twig = new Environment(
                new FilesystemLoader(__DIR__ . "/../resource/views"),
                [
                    "debug" => true,
                ]
            );

            $this->twig->addFunction(
                new TwigFunction(
                    "fratily_debugbar_panel",
                    [$this, "callbackRenderCollector"]
                )
            );

            $this->twig->addFilter(
                new \Twig\TwigFilter("ucfirst", "ucfirst")
            );

            $this->twig->addExtension(
                new \Twig\Extension\DebugExtension
            );
        }
    }

    /**
     * コレクターを描画するためのメソッド
     *
     * Twigテンプレートから拡張関数として呼ばれる。
     * その他の場所から呼ぶと文字列が出力されるので注意。
     *
     * @param   Collector\CollectorInterface    $collector
     *
     * @return  void
     */
    public function callbackRenderCollector(Collector\CollectorInterface $collector){
        $this->initTwig();

        if(!array_key_exists($collector->getPanelClass(), $this->panels)){
            if(!class_exists($collector->getPanelClass())
                || !in_array(
                    Panel\PanelInterface::class,
                    class_implements($collector->getPanelClass())
                )
            ){
                throw new \LogicException;  // パネルクラス名が不正
            }

            $panelName  = $collector->getPanelClass();

            $this->panels[$panelName]   = new $panelName($this->twig);
        }

        echo $this->panels[$panelName]->render($collector);
    }
}