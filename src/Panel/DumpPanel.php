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

use Fratily\DebugBar\Block\DumpListBlock;

class DumpPanel extends AbstractPanel{

    /**
     * @var DumpListBlock
     */
    private $dump;

    /**
     * Constructor
     *
     * @param   string  $name
     */
    public function __construct(string $name){
        $this->dump = new DumpListBlock();

        parent::__construct($name, [
            $this->dump,
        ]);
    }

    /**
     * ダンプする値を追加する
     *
     * @param   mixed   $val
     * @param   string  $file
     * @param   int $line
     *
     * @return  $this
     */
    public function dump($val, string $file = null, int $line = null){
        if($file === null || $line === null){
            $trace  = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1);

            $file   = $trace[0]["file"] ?? "unknown";
            $line   = $trace[0]["line"] ?? 0;
        }

        $this->dump->addValue($val, $file, $line);

        return $this;
    }
}