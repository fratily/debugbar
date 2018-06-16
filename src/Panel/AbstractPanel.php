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

    /**
     * {@inheritdoc}
     */
    public function getName(){
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function SetName(string $name){
        $name   = trim($name);

        if($name === ""){
            throw new \InvalidArgumentException();
        }

        $this->name = $name;
    }

    /**
     * ブロックを登録する
     *
     * @param   BlockInterface  $block
     *
     * @return  void
     */
    protected function addBlock(BlockInterface $block){
        $this->blocks[] = $block;
    }

    public function getIterator(){
        foreach($this->blocks as $block){
            yield $block;
        }
    }
}