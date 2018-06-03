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

class MessageCollector extends AbstractCollector{

    private $messages;

    public function __construct(){
        $this->messages = [];
    }

    public function addMessage(string $message, $level = null){
        $this->messages[]   = [
            "level"     => $level,
            "message"   => $message,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getPanelClass(){
        return \Fratily\DebugBar\Panel\MessagePanel::class;
    }

    /**
     * {@inheritdoc}
     */
    public function collect(){
        return [
            "messages"  => $this->messages,
        ];
    }
}