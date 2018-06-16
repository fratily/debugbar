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

use Fratily\DebugBar\Block\MessageListBlock;
use Psr\Log\LogLevel;

class MessagePanel extends AbstractPanel{

    const LEVEL = [
        LogLevel::EMERGENCY => "emergency",
        LogLevel::ALERT     => "alert",
        LogLevel::CRITICAL  => "critical",
        LogLevel::ERROR     => "error",
        LogLevel::WARNING   => "warning",
        LogLevel::NOTICE    => "notice",
        LogLevel::INFO      => "info",
        LogLevel::DEBUG     => "debug",
    ];

    const ICON  = [
        LogLevel::EMERGENCY => MessageListBlock::ICON_ERR,
        LogLevel::ALERT     => MessageListBlock::ICON_ERR,
        LogLevel::CRITICAL  => MessageListBlock::ICON_ERR,
        LogLevel::ERROR     => MessageListBlock::ICON_ERR,
        LogLevel::WARNING   => MessageListBlock::ICON_WARN,
        LogLevel::NOTICE    => MessageListBlock::ICON_WARN,
        LogLevel::INFO      => MessageListBlock::ICON_INFO,
        LogLevel::DEBUG     => MessageListBlock::ICON_NULL,
    ];

    /**
     * @var MessageListBlock
     */
    private $message;

    /**
     * Constructor
     */
    public function __construct(){
        $this->message  = new MessageListBlock();

        $this->addBlock($this->message);
    }

    public function addMessage(string $message, $level = LogLevel::DEBUG){
        $this->message->addMessage($message, self::ICON[$level] ?? MessageListBlock::ICON_NULL);

        return $this;
    }
}