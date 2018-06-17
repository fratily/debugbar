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

class TimelineBlock extends AbstractBlock implements \IteratorAggregate{

    /**
     * @var float
     */
    private $execution;

    /**
     * @var mixed[]
     */
    private $lines  = [];

    /**
     * {@inheritdoc}
     */
    public function __construct(string $title = null, Template $template = null){
        parent::__construct($title, $template ?? new Template(
            "block/timeline.twig",
            Template::T_FILE
        ));
    }

    /**
     * 実行時間を設定する
     *
     * @param   float   $time
     *
     * @return  void
     */
    public function setExecutionTime(float $time){
        if($time <= 0){
            throw new \InvalidArgumentException();
        }

        $this->execution    = $time;
    }

    /**
     * ラインを追加する
     *
     * 同名のラインは上書きされる。
     *
     * @param   string  $name
     * @param   float   $start
     *  タイムライン開始時間からの相対経過時間
     * @param   float   $runtime
     *  ラインの実行時間
     *
     * @return  void
     */
    public function addLine(string $name, float $start, float $runtime){
        if($runtime < 0){
            throw new \InvalidArgumentException();
        }

        $this->lines[$name] = [
            "name"      => $name,
            "start"     => $start,
            "runtime"   => $runtime,
            "percent"   => [
                "start"     => null,
                "runtime"   => null,
            ],
        ];
    }

    /**
     * 実行時間に対して比較時間の長さをパーセントで取得する
     *
     * @param   float   $comp
     *  比較する時間
     *
     * @return  float
     */
    private function getProportion(float $comp){
        $minus  = $comp < 0 ? true : false;
        $result = round(abs($comp) / $this->execution * 100, 2);

        return $minus ? $result * -1 : $result;
    }

    public function getIterator(){
        if($this->execution === null){
            throw new \LogicException;
        }

        foreach($this->lines as $name => $data){
            $start      = $this->getProportion($data["start"]);
            $runtime    = $this->getProportion($data["runtime"]);

            $this->lines[$name]["percent"]["start"]     = $start;
            $this->lines[$name]["percent"]["runtime"]   = $runtime;
        }

        yield from array_values($this->lines);
    }
}