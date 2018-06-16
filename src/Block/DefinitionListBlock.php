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

use Fratily\DebugBar\Block\AbstractBlock;

class DefinitionListBlock extends AbstractBlock implements \IteratorAggregate{

    /**
     * @var string[][]
     */
    private $list;

    /**
     * Constructor
     */
    public function __construct(){
        $this->list = [];
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate(){
        return "block/dl.twig";
    }

    /**
     * 定義を追加する
     *
     * @param   string  $term
     * @param   string  $description
     *
     * @return  $this
     */
    public function addDefinition(string $term, string $description){
        $this->list[]   = [
            "term"          => $term,
            "description"   => $description,
        ];

        return $this;
    }

    public function getIterator(){
        yield from $this->list;
    }
}