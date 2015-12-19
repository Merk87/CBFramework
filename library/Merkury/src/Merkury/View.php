<?php

namespace Merkury;

class View
{
    private static $_base_path = '';

    private static $_extend = [];

    private static $_content = '';

    private static $_vars = [];

    public static function setBasePath($base_path)
    {
        self::$_base_path = realpath($base_path);
    }

    public static function render($template, $params = null)
    {
        if(!empty($params)){
            foreach ($params as $key => $param){
                self::set($key, $param);
            }
        }

        $text = self::_requireToString($template);

        while(!empty(self::$_extend)){
            self::$_content = $text;
            $text = self::_requireToString(array_pop(self::$_extend));
        }


        return $text;
    }

    public static function templateExtend($template)
    {

        array_push(self::$_extend, $template);
    }

    public static function content()
    {
        echo self::$_content;
    }

    private static function _requireToString($template)
    {
        ob_start();
        require self::$_base_path . DIRECTORY_SEPARATOR . $template;
        return ob_get_clean();
    }

    public static function set($name, $value)
    {
        self::$_vars[$name] = $value;
    }

    public static function get($name)
    {
        return isset(self::$_vars[$name]) ? self::$_vars[$name] : null;
    }

    public static function printVar($name)
    {
        echo isset(self::$_vars[$name]) ? self::$_vars[$name] : '';
    }

    public static function returnObject($name)
    {

        return self::$_vars[$name];
    }

    public static function dump($name)
    {
        isset(self::$_vars[$name]) ? var_dump(self::$_vars[$name]) : null;
    }

    public static function partial($partial)
    {
        echo self::_requireToString($partial);
    }
}
