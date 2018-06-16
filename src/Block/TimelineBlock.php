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

class TimelineBlock extends AbstractBlock implements \IteratorAggregate{

    /**
     * @var float
     */
    private $measurement;

    /**
     * @var mixed[]
     */
    private $lines;

    /**
     * Constructor
     */
    public function __construct(){
        $this->measurement  = null;
        $this->lines        = [];
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate(){
        return "block/timeline.twig";
    }

    public function setMeasurementTime(float $time){
        $this->measurement  = abs($time);
    }

    public function addLine(string $name, float $start, float $runtime){
        $this->lines[$name] = [
            "name"      => $name,
            "start"     => abs($start),
            "runtime"   => abs($runtime),
            "percent"   => [
                "start"     => null,
                "runtime"   => null,
            ],
        ];
    }

    public function getIterator(){
        $measurement    = $this->measurement;

        if($measurement === null){
            throw new \LogicException;
        }

        $result = array_map(
            function($val) use ($measurement){
                if($measurement <= $val["start"]){
                    return null;
                }

                $val["percent"]["start"]    = round($val["start"] / $measurement * 100, 2);
                $val["percent"]["runtime"]  = $measurement < ($val["start"] + $val["runtime"])
                    ? round(($measurement - $val["start"]) / $measurement * 100, 2)
                    : round($val["runtime"] / $measurement * 100, 2)
                ;

                return $val;
            },
            array_values($this->lines)
        );

        yield from $result;
    }
}