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

use Fratily\DebugBar\Block\TabsBlock;
use Fratily\DebugBar\Block\MetricsBlock;
use Fratily\DebugBar\Block\PHPInfoBlock;


class PHPInfoPanel extends AbstractPanel{

    /**
     * @var PHPInfoBlock
     */
    private $phpinfo;

    /**
     * @var MetricsBlock
     */
    private $metrics;

    /**
     * Constructor
     *
     * @param   string  $name
     */
    public function __construct(string $name){
        $tabs           = new TabsBlock();
        $this->metrics  = new MetricsBlock();
        $this->phpinfo  = new PHPInfoBlock();

        $tabs->addTab("standard info", $this->metrics);
        $tabs->addTab("phpinfo", $this->phpinfo);

        $this->metrics->addTextMetric("PHP version", PHP_VERSION);
        $this->metrics->addTextMetric("Timezone", date_default_timezone_get());

        parent::__construct($name, [$tabs]);
    }
}