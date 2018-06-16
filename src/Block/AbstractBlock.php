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

abstract class AbstractBlock implements BlockInterface{

    private $title;

    /**
     * {@inheritdoc}
     */
    public function getTitle(){
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle(string $title){
        $this->title    = trim($title);
        $this->title    = $this->title === "" ? null : $this->title;
    }
}