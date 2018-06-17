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

class PHPInfoBlock extends AbstractBlock{

    /**
     * {@inheritdoc}
     */
    public function __construct(string $title = null, Template $template = null){
        parent::__construct($title, $template ?? new Template(
            "block/phpinfo.twig",
            Template::T_FILE
        ));
    }

    /**
     * phpinfo()の結果を取得する
     *
     * @return  string
     */
    public function getInfo(){
        ob_start();
        phpinfo();

        $dom    = new \DOMDocument();
        $new    = new \DOMDocument();
        @$dom->loadHTML(ob_get_clean());

        $list   = (new \DOMXPath($dom))->query("//div[@class='center']/*");

        for($i = 0; $i < $list->length; $i++){
            $new->appendChild($new->importNode($list->item($i), true));
        }

        return $new->saveHTML();
    }
}