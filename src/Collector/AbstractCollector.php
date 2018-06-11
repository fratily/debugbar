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
namespace Fratily\DebugBar\Collector;

abstract class AbstractCollector implements CollectorInterface{

    /**
     * @var string|null
     */
    protected $name;

    /**
     * {@inheritdoc}
     */
    public function getName(){
        return $this->name ?? static::class;
    }

    /**
     * {@inheritdoc}
     */
    public function setName(string $name){
        $this->name = trim($name);
    }
}