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

abstract class AbstractBlock implements BlockInterface{

    const DEFAULT_TEMPLATE      = "<span>Template is undefined.</span>";
    const DEFAULT_TEMPLATE_TYPE = Template::T_TEXT;

    /**
     * @var string|null
     */
    private $title;

    /**
     * @var Template
     */
    private $template;

    /**
     * Constructor
     *
     * @param   string  $title
     * @param   Template    $template
     */
    public function __construct(string $title = null, Template $template = null){
        $this->title    = trim($this->title) === "" ? null : trim($this->title);
        $this->template = $template ?? new Template(
            self::DEFAULT_TEMPLATE,
            self::DEFAULT_TEMPLATE_TYPE
        );

        if($title !== null){
            $this->setTitle($title);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle(){
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate(): Template{
        return $this->template;
    }
}