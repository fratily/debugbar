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
        LogLevel::EMERGENCY => "error",
        LogLevel::ALERT     => "error",
        LogLevel::CRITICAL  => "error",
        LogLevel::ERROR     => "error",
        LogLevel::WARNING   => "warn",
        LogLevel::NOTICE    => "warn",
        LogLevel::INFO      => "info",
        LogLevel::DEBUG     => "null",
    ];

    /**
     * {@inheritdoc}
     */
    protected function normalize(array $data){
        $messages   = [];

        foreach($data["messages"] as $message){
            if(!is_array($message)){
                $message    = [
                    "level"     => LogLevel::DEBUG,
                    "message"   => $message,
                ];
            }

            $level      = self::normalizeLevel($message["level"] ?? null);
            $icon       = self::ICON[$level];
            $message    = self::normalizeMessage($message["message"] ?? null);

            $messages[] = [
                "level"     => $level,
                "icon"      => $icon,
                "message"   => $message,
            ];
        }

        $data["messages"]   = $messages;

        return $data;
    }

    protected function normalizeLevel($level){
        if(!is_string($level) || !array_key_exists($level, self::LEVEL)){
            $level  = LogLevel::DEBUG;
        }

        return $level;
    }

    protected function normalizeMessage($message){
        if(!is_scalar($message) && !(is_object($message) && method_exists($message, "__toString"))){
            $message    = "This message can not be displayed.";
        }else{
            $message    = (string)$message;
        }

        return $message;
    }

    /**
     * {@inheritdoc}
     */
    protected function getTplName(){
        return "panel/message.twig";
    }
}