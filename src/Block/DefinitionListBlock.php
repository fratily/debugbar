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

class DefinitionListBlock extends AbstractBlock implements \IteratorAggregate{

    /**
     * @var string[][]
     */
    private $list   = [];

    /**
     * {@inheritdoc}
     */
    public function __construct(string $title = null, Template $template = null){
        parent::__construct($title, $template ?? new Template(
            "block/dl.twig",
            Template::T_FILE
        ));
    }

    /**
     * 定義を追加する
     *
     * @param   string  $term
     * @param   mixed|mixed[]   $description
     *
     * @return  $this
     */
    public function addDefinition(string $term, $description){
        $this->list[]   = [
            "term"          => $term,
            "description"   => array_filter(
                (array)$description,
                function($v){
                    return is_scalar($v)
                        || (is_object($v) && method_exists($v, "__toString"));
                }
            ),
        ];

        return $this;
    }

    public function getIterator(){
        yield from $this->list;
    }
}