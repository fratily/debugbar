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

class MetricsBlock extends AbstractBlock implements \IteratorAggregate{

    /**
     * @var string[][]
     */
    private $metrics    = [];

    /**
     * {@inheritdoc}
     */
    public function getTemplate(){
        return "block/metrics.twig";
    }

    /**
     * メトリックスを追加する
     *
     * @param   string  $name
     * @param   string  $value
     * @param   string  $unit
     *
     * @return  $this
     */
    public function addMetric(string $name, string $value, string $unit = null){
        $this->metrics[]    = [
            "value" => [
                "data"  => $value,
                "unit"  => $unit,
            ],
            "name"  => $name,
        ];

        return $this;
    }

    public function getIterator(){
        yield from $this->metrics;
    }
}