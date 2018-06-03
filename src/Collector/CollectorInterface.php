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

interface CollectorInterface{

    /**
     * コレクターの名前を取得する
     *
     * @return  string
     */
    public function getName();

    /**
     * コレクターの名前を設定する
     *
     * @param   string  $name
     *
     * @return  void
     */
    public function setName(string $name);

    /**
     * パネルクラス名を取得する
     *
     * @return  string
     */
    public function getPanelClass();

    /**
     * 収集したデータリストを取得する
     *
     * 各パネルで描画文字列を構成するために利用される。
     *
     * @return  mixed[]
     */
    public function collect();
}