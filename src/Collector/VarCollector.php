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

class VarCollector extends AbstractCollector{

    private $vars;

    public function __construct(){
        $this->vars = [];
    }

    public function dump($var){
        $this->vars[]   = $var;
    }

    /**
     * {@inheritdoc}
     */
    public function getPanelClass(){
        return \Fratily\DebugBar\Panel\DumpPanel::class;
    }

    /**
     * {@inheritdoc}
     */
    public function collect(){
        return [
            "vars"  => $this->vars,
        ];
    }
}