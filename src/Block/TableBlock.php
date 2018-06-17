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

class TableBlock extends AbstractBlock implements \IteratorAggregate{

    /**
     * @var string[]
     */
    private $header;

    /**
     * @var int
     */
    private $count;

    /**
     * @var string[][]
     */
    private $body   = [];

    /**
     * {@inheritdoc}
     */
    public function __construct(array $header, string $title = null, Template $template = null){
        if(empty($header)){
            throw new \InvalidArgumentException();
        }

        parent::__construct($title, $template ?? new Template(
            "block/table.twig",
            Template::T_FILE
        ));

        $this->count    = count($header);
        $this->header   = array_map(function($v){
            if(is_scalar($v)
                || (is_object($v) && method_exists($v, "__toString"))
            ){
                return $v;
            }

            return "";
        }, $header);
    }

    /**
     * 行を追加する
     *
     * @param   string  ...$columns
     *
     * @return  $this
     *
     * @throws  \InvalidArgumentException
     */
    public function addRow(string ...$columns){
        if($this->count !== count($columns)){
            throw new \InvalidArgumentException();
        }

        $this->body[]   = $columns;

        return $this;
    }

    /**
     * 配列を使用して行を追加する
     *
     * @param   string  $columns
     *
     * @return  $this
     *
     * @throws  \InvalidArgumentException
     */
    public function addRowByArray(array $columns){
        return call_user_func_array([$this, "addRow"], $columns);
    }

    /**
     * ヘッダーを取得する
     *
     * @return  string[]
     */
    public function getHeader(){
        return $this->header;
    }

    /**
     * ボディを取得する
     *
     * @return  string[][]
     */
    public function getBody(){
        return $this->body;
    }

    public function getIterator(){
        yield from $this->body;
    }
}