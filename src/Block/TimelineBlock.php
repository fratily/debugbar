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
     *  計測開始時刻から計測終了時刻までの経過時間(単位:秒)
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
     * タイムラインを追加する
     *
     * 同名のタイムラインは上書きされる。
     *
     * @param   string  $name
     * @param   float   $start
     *  タイムライン開始時刻からの相対経過時間(単位:秒)
     * @param   float   $runtime
     *  タイムラインの実行時間(単位:秒)
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
        ];
    }

    /**
     * 実行時間に対して比較時間の長さをパーセントで取得する
     *
     * @param   float   $comp
     *  比較する時間(単位:秒)
     *
     * @return  float
     *  少数第二位までのパーセント値
     */
    private function getProportion(float $comp){
        return round($comp / $this->execution * 100, 2);
    }

    public function getIterator(){
        if($this->execution === null){
            throw new \LogicException;
        }

        foreach($this->lines as $data){
            $start      = $this->getProportion(abs($data["start"]));
            $runtime    = $this->getProportion($data["runtime"]);

            if($data["start"] < 0){
                $start  = $start * -1;
            }

            $data["runtime"]    = round($data["runtime"] * 1000, 2);
            $data["percent"]    = [
                    "start"     => $start,
                    "runtime"   => $runtime,
            ];

            yield $data;
        }
    }
}