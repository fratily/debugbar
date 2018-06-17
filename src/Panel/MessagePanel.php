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

use Fratily\DebugBar\Template;
use Fratily\DebugBar\Block\MessageListBlock;
use Psr\Log\LogLevel;

class MessagePanel extends AbstractPanel{

    const LV2ICON  = [
        LogLevel::EMERGENCY => Template::ICON_ERROR,
        LogLevel::ALERT     => Template::ICON_ERROR,
        LogLevel::CRITICAL  => Template::ICON_ERROR,
        LogLevel::ERROR     => Template::ICON_ERROR,
        LogLevel::WARNING   => Template::ICON_WARN,
        LogLevel::NOTICE    => Template::ICON_WARN,
        LogLevel::INFO      => Template::ICON_INFO,
        LogLevel::DEBUG     => Template::ICON_NULL,
    ];

    /**
     * @var MessageListBlock
     */
    private $message;

    /**
     * Constructor
     *
     * @param   string  $name
     */
    public function __construct(string $name){
        $this->message  = new MessageListBlock();

        parent::__construct($name, [
            $this->message,
        ]);
    }

    /**
     * メッセージを追加する
     *
     * @param   string  $message
     * @param   mixed   $level
     *
     * @return  $this
     */
    public function addMessage(string $message, $level = LogLevel::DEBUG){
        $this->message->addMessage(
            $message,
            self::LV2ICON[$level] ?? Template::ICON_NULL
        );

        return $this;
    }
}