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

class DumpListBlock extends AbstractBlock implements \IteratorAggregate{

    /**
     * @var mixed[]
     */
    private $values = [];

    /**
     * {@inheritdoc}
     */
    public function __construct(string $title = null, Template $template = null){
        parent::__construct($title, $template ?? new Template(
            "block/dump_list.twig",
            Template::T_FILE
        ));
    }

    /**
     * 値を追加する
     *
     * @param   mixed   $value
     * @param   string  $file
     * @param   int $line
     *
     * @return  $this
     */
    public function addValue($value, string $file, int $line){
        $this->values[] = [
            "value" => $value,
            "file"  => $file,
            "line"  => $line,
        ];

        return $this;
    }

    public function getIterator(){
        yield from $this->values;
    }
}