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

use Fratily\DebugBar\Template;
use Fratily\DebugBar\Block\AbstractBlock;

class MessageListBlock extends AbstractBlock implements \IteratorAggregate{

    /**
     * @var string[][]
     */
    private $messages   = [];

    /**
     * {@inheritdoc}
     */
    public function __construct(string $title = null, Template $template = null){
        parent::__construct($title, $template ?? new Template(
            "block/message_list.twig",
            Template::T_FILE
        ));
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
    public function addMessage(string $message, int $icon = Template::ICON_NULL){
        $this->messages[]   = [
            "icon"      => Template::getIconName($icon),
            "message"   => trim($message),
        ];

        return $this;
    }

    public function getIterator(){
        yield from $this->messages;
    }
}