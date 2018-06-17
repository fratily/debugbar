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

interface BlockInterface{

    /**
     * ブロックのタイトルを取得する
     *
     * @return  string|null
     */
    public function getTitle();

    /**
     * テンプレートを取得する
     *
     * @return  \Fratily\DebugBar\Template
     */
    public function getTemplate(): \Fratily\DebugBar\Template;
}