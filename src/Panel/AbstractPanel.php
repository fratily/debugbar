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

use Fratily\DebugBar\Block\BlockInterface;

abstract class AbstractPanel implements PanelInterface{

    /**
     * @var string
     */
    private $name;

    /**
     * @var BlockInterface[]
     */
    private $blocks = [];

    public function __construct(string $name, array $blocks = []){
        $name   = trim($name);
        $blocks = array_filter($blocks, function($v){
            return $v instanceof BlockInterface;
        });

        if($name === ""){
            throw new \InvalidArgumentException();
        }

        $this->name     = $name;
        $this->blocks   = $blocks;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(){
        return $this->name;
    }

    public function getIterator(){
        $this->beforeGetIterator();

        foreach($this->blocks as $block){
            yield $block;
        }
    }

    /**
     * getIteratorの前に実行される
     */
    protected function beforeGetIterator(){

    }
}