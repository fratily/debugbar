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
namespace Fratily\DebugBar\Panel;

use Fratily\DebugBar\Collector\CollectorInterface;
use Twig\Environment;


abstract class AbstractPanel implements PanelInterface{

    /**
     * @var Environment
     */
    private $twig;

    public function __construct(Environment $twig){
        $this->twig = $twig;
    }

    /**
     *
     * @param   CollectorInterface  $collector
     *
     * @return  string
     */
    public function render(CollectorInterface $collector){
        if($collector->getPanelClass() !== static::class){
            return "";
        }

        return $this->twig->render(
            $this->getTplName(),
            $this->normalize($collector->collect())
        );
    }

    /**
     * コレクターの値を正規化する
     *
     * @param   mixed[] $data
     *
     * @return  mixed[]
     */
    abstract protected function normalize(array $data);

    /**
     * Twigテンプレートファイル名を取得する
     *
     * @return  string
     */
    abstract protected function getTplName();
}