<?php
/**
 * Created by PhpStorm.
 * User: qiandutianxia
 * Date: 2018/4/27 0027
 * Time: 14:52
 */

namespace Raychars\Framework;


use Raychars\Exception\ParseErrorException;
use Raychars\Exception\UrlErrorException;

class Route
{
    public static $url_list;
    public static $url_map = [];
    public static $agvs = [];


    static public function get($url_name, $path, $agvs = [])
    {
        self::$agvs[$url_name] = $agvs;

        if (!strpos($path, '@')) {
            throw new ParseErrorException($path);
        }
        $tmp = explode("@", $path);
        if (strpos($tmp[0], '/')) {
            $project = explode("/", $tmp[0]);
            self::$url_list = array_merge($project, $tmp[1]);
        } else {
            self::$url_list = array_merge(array('app'), $tmp);
        }

        self::$url_map[$url_name] = self::$url_list;
    }

    public static function post($url_name, $path)
    {

    }

    static public function parseUrl($url)
    {
//        p(self::$url_map);
        if (!isset(self::$url_map[$url])) {
            throw new UrlErrorException($url);
        }
        $map = self::$url_map[$url];
        $class_name = ucfirst($map[0]) . '\\Controller\\' . $map[1];
        $reflect = new \ReflectionClass($class_name);
        $obj = $reflect->newInstance();
//        p(self::$agvs);
        call_user_func_array(array($obj, $map[2]), self::$agvs[$url]);
    }

}
