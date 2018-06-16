<?php
/**
 * FratilyPHP Debug
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @author      Kento Oka <kento-oka@kentoka.com>
 * @copyright   (c) Kento Oka
 * @license     MIT
 * @since       1.0.0
 */
namespace Fratily\DebugBar;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 *
 */
class DebugBar{

    /**
     * @var Panel\PanelInterface[]
     */
    private $panels = [];

    /**
     * @var Environment
     */
    private $twig;

    /**
     * Constructor
     *
     * @param   Panel\PanelInterface[]  $panels
     */
    public function __construct(array $panels = []){
        foreach($panels as $panel){
            $this->addPanel($panel);
        }
    }

    public function getPanels(){
        return $this->panels;
    }

    public function addPanel(Panel\PanelInterface $panel){
        $this->panels[] = $panel;
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
            "panels"    => $this->panels
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

            $this->twig->addExtension(
                new \Twig\Extension\DebugExtension
            );
        }
    }
}