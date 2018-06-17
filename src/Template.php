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
namespace Fratily\DebugBar;

/**
 *
 */
class Template{

    const T_FILE    = "file";
    const T_TEXT    = "text";

    const ICON_NULL     = 0;
    const ICON_INFO     = 1;
    const ICON_WARN     = 2;
    const ICON_ERROR    = 3;
    const ICON_CROSS    = 4;
    const ICON_CHECK    = 5;

    const ICON_NAMES    = [
        self::ICON_NULL     => "null",
        self::ICON_INFO     => "info",
        self::ICON_WARN     => "warn",
        self::ICON_ERROR    => "error",
        self::ICON_CROSS    => "cross",
        self::ICON_CHECK    => "check",
    ];

    /**
     * @var string
     */
    private $template;

    /**
     * @var string
     */
    private $type;

    /**
     * Constructor
     *
     * @param   string  $template
     * @param   string  $type
     *
     * @throws  \InvalidArgumentException
     */
    public function __construct(string $template, string $type){
        if(!in_array($type, [self::T_FILE, self::T_TEXT])){
            throw new \InvalidArgumentException();
        }

        $this->template = $template;
        $this->type     = $type;
    }

    /**
     * テンプレートを取得する
     *
     * これがテンプレートとして機能する文字列なのか、
     * それともテンプレートファイル名なのかはgetType()で判断する。
     *
     * @return  string
     */
    public function getTemplate(){
        return $this->template;
    }

    /**
     * テンプレートのタイプを取得する
     *
     * getTemplateで取得できる文字列が
     * テンプレート文字列なのかファイル名なのかを判断する
     *
     * @return  string
     */
    public function getType(){
        return $this->type;
    }

    /**
     * アイコンを取得する
     *
     * @param   mixed   $icon
     *
     * @return  string
     */
    public static function getIconName($icon){
        $icon   = is_scalar($icon) ? $icon : self::ICON_NULL;
        
        return self::ICON_NAMES[$icon] ?? self::ICON_NAMES[self::ICON_NULL];
    }

    /**
     * アイコンが存在するか
     *
     * @param   mixed   $icon
     *
     * @return  bool
     */
    public static function iconExists($icon){
        return array_key_exists($icon, self::ICON_NAMES);
    }
}