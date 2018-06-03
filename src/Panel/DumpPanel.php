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
namespace Fratily\DebugBar\Panel;

class DumpPanel extends AbstractPanel{

    /**
     * {@inheritdoc}
     */
    protected function normalize(array $data){
        if(!is_array($data["vars"])){
            $data["vars"]   = (array)$data["vars"];
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    protected function getTplName(){
        return "panel/dump.twig";
    }
}