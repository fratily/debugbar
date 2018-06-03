<?php
/**
 * FratilyPHP Debug
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @author      Kento Oka <kento.oka@kentoka.com>
 * @copyright   (c) Kento Oka
 * @license     MIT
 * @since       1.0.0
 */
namespace Fratily\DebugBar\Collector;

class TimeCollector extends AbstractCollector{

    /**
     * @var float
     */
    private $start;

    /**
     * @var float|null
     */
    private $minStartTime;

    /**
     * @var string[]
     */
    private $names;

    /**
     * @var int[]
     */
    private $startTimes;

    /**
     * @var int[]
     */
    private $endTimes;

    public function __construct(){
        $this->start        = microtime(true);
        $this->end          = null;
        $this->names        = [];
        $this->startTimes   = [];
        $this->endTimes     = [];
    }

    public function setStartTime(float $start){
        if($this->minStartTime === null
            || $start <= $this->minStartTime
        ){
            $this->start    = $start;
        }else{
            throw new \InvalidArgumentException();
        }

        return $this;
    }

    public function start(string $name){
        $start  = microtime(true);

        if(array_key_exists($name, $this->startTimes)){
            throw new \LogicException;
        }

        if($start < $this->start){
            throw new \InvalidArgumentException();
        }

        if($this->minStartTime === null
            || $start < $this->minStartTime
        ){
            $this->minStartTime = $start;
        }

        $this->names[]              = $name;
        $this->startTimes[$name]    = $start;
    }

    public function end(string $name){
        $end    = microtime(true);

        if(!array_key_exists($name, $this->startTimes)){
            throw new \LogicException;
        }

        if(array_key_exists($name, $this->endTimes)){
            throw new \LogicException;
        }

        $this->endTimes[$name]  = $end;
    }

    /**
     * {@inheritdoc}
     */
    public function getPanelClass(){
        return \Fratily\DebugBar\Panel\TimelinePanel::class;
    }

    /**
     * {@inheritdoc}
     */
    public function collect(){
        $_end   = microtime(true);
        $result = [];

        foreach($this->names as $name){
            $start  = $this->startTimes[$name] - $this->start;
            $end    = ($this->endTimes[$name] ?? $_end) - $this->start;
            $run    = $end - $start;

            $result[]   = [
                "name"      => $name,
                "start"     => $start,
                "end"       => $end,
                "runtime"   => round($run * 1000, 2),
                "start_p"   => round($start / ($_end - $this->start) * 100, 2),
                "runtime_p" => round($run / ($_end - $this->start) * 100, 2),
            ];
        }

        return [
            "times" => $result,
        ];
    }
}