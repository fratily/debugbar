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

use Fratily\DebugBar\Block\TimelineBlock;

class TimelinePanel extends AbstractPanel{

    /**
     * @var TimelineBlock
     */
    private $timeline;

    /**
     * @var float
     */
    private $start;

    /**
     * @var float[]
     */
    private $lineStart  = [];

    /**
     * Constructor
     *
     * @param   string  $name
     * @param   float   $start
     */
    public function __construct(string $name, float $start){
        $this->timeline     = new TimelineBlock();
        $this->start        = $start;
        $this->lineStart    = [];

        parent::__construct($name, [
            $this->timeline,
        ]);
    }

    /**
     * タイムラインの終了時間を設定する
     *
     * マイクロ秒精度UNIXタイムスタンプで設定する
     *
     * @param   float   $time
     *
     * @return  void
     */
    public function setEndTime(float $time){
        if($time <= $this->start){
            throw new \LogicException;
        }

        $this->timeline->setExecutionTime($time - $this->start);
    }

    /**
     * 指定名のタイムラインを開始する
     *
     * @param   string  $name
     *
     * @return  void
     */
    public function start(string $name){
        $this->lineStart[$name] = microtime(true);
    }

    /**
     * 指定名のタイムラインを終了する
     *
     * @param   string  $name
     *
     * @return  void
     */
    public function end(string $name){
        $time   = microtime(true);

        if(!array_key_exists($name, $this->lineStart)){
            throw new \LogicException;
        }

        $this->timeline->addLine(
            $name,
            $this->lineStart[$name] - $this->start,
            $time - $this->lineStart[$name]
        );
    }
}