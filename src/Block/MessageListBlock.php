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

class MessageListBlock extends AbstractBlock implements \IteratorAggregate{

    const ICON_NULL = 0;
    const ICON_INFO = 1;
    const ICON_WARN = 2;
    const ICON_ERR  = 3;

    const ICON_NAMES    = [
        self::ICON_NULL => "null",
        self::ICON_INFO => "info",
        self::ICON_WARN => "warn",
        self::ICON_ERR  => "error",
    ];

    /**
     * @var string[][]
     */
    private $messages;

    /**
     * Constructor
     */
    public function __construct(){
        $this->messages = [];
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate(){
        return "block/message_list.twig";
    }

    /**
     * ヘッダー行を取得する
     */
    public function getHeader(){
        return $this->header;
    }

    /**
     * メッセージを追加する
     *
     * @param   string  $message
     * @param   int $icon
     *
     * @return  $this
     *
     * @throws  \InvalidArgumentException
     */
    public function addMessage(string $message, int $icon = self::ICON_NULL){
        if(!array_key_exists($icon, self::ICON_NAMES)){
            throw new \InvalidArgumentException();
        }

        $this->messages[]   = [
            "icon"      => self::ICON_NAMES[$icon],
            "message"   => trim($message),
        ];

        return $this;
    }

    public function getIterator(){
        yield from $this->messages;
    }
}