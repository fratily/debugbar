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
namespace Fratily\DebugBar\Block;

use Fratily\DebugBar\Template;
use Fratily\DebugBar\Block\AbstractBlock;

class TabsBlock extends AbstractBlock implements \IteratorAggregate{

    /**
     * @var BlockInterface[]
     */
    private $tabs   = [];

    /**
     * {@inheritdoc}
     */
    public function __construct(string $title = null, Template $template = null){
        parent::__construct($title, $template ?? new Template(
            "block/tabs.twig",
            Template::T_FILE
        ));
    }

    /**
     * コンテンツを追加する
     *
     * @param   string  $name
     * @param   BlockInterface  $block
     *
     * @return  $this
     */
    public function addTab(string $name, BlockInterface $block){
        $this->tabs[]   = [
            "name"  => $name,
            "block" => $block,
        ];

        return $this;
    }

    /**
     * タブブロックの固有IDを取得する
     *
     * @return  string
     */
    public function getId(){
        return spl_object_hash($this);
    }

    public function getIterator(){
        yield from $this->tabs;
    }
}