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

class MetricsBlock extends AbstractBlock implements \IteratorAggregate{

    const TYPE_TEXT = "text";
    const TYPE_ICON = "icon";

    /**
     * @var string[][]
     */
    private $metrics    = [];

    /**
     * {@inheritdoc}
     */
    public function __construct(string $title = null, Template $template = null){
        parent::__construct($title, $template ?? new Template(
            "block/metrics.twig",
            Template::T_FILE
        ));
    }

    /**
     * メトリックスを追加する
     *
     * @param   string  $name
     * @param   string  $type
     * @param   mixed[] $value
     *
     * @return  void
     */
    private function addMetric(string $name, string $type, array $value){
        $this->metrics[$name]   = [
            "name"  => $name,
            "type"  => $type,
            "value" => $value,
        ];
    }

    /**
     * テキストメトリックスを追加する
     *
     * @param   string  $name
     * @param   string  $value
     * @param   string  $unit
     *
     * @return  void
     */
    public function addTextMetric(string $name, string $value, string $unit = null){
        $this->addMetric(
            trim($name),
            self::TYPE_TEXT,
            [
                "data"  => trim($value),
                "unit"  => trim($unit)
            ]
        );
    }

    /**
     * アイコンメトリックスを追加する
     *
     * @param   string  $name
     * @param   mixed   $icon
     *
     * @return  void
     *
     * @thrws   \InvalidArgumentException
     */
    public function addIconMetric(string $name, $icon){
        if(!array_key_exists($icon, self::ICON_NAMES)){
            throw new \InvalidArgumentException();
        }

        $this->addMetric(
            trim($name),
            self::TYPE_ICON,
            [
                "icon"  => $icon,
            ]
        );
    }

    public function getIterator(){
        yield from $this->metrics;
    }
}