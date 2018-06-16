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
    private $body;

    /**
     * Constructor
     */
    public function __construct(){
        $this->header   = null;
        $this->count    = null;
        $this->body     = [];
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate(){
        return "block/table.twig";
    }

    /**
     * ヘッダー行を取得する
     */
    public function getHeader(){
        return $this->header;
    }

    /**
     * テーブルヘッダーを設定する
     *
     * @param   string  ...$columns
     *
     * @return  $this
     */
    public function setHeader(string ...$columns){
        $this->header   = $columns;
        $this->count    = count($columns);

        return $this;
    }

    /**
     * デーブルボディーの行を追加する
     *
     * @param   string  ...$columns
     *
     * @return  $this
     *
     * @throws  \InvalidArgumentException
     */
    public function addRow(string ...$columns){
        if($this->count !== null && $this->count !== count($columns)){
            throw new \InvalidArgumentException();
        }

        $this->body[]   = $columns;

        return $this;
    }

    public function getIterator(){
        yield from $this->body;
    }
}