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
    public static $get_url_list;
    public static $get_url_map = [];
    public static $agvs = [];
    public static $post_url_list;
    public static $post_url_map = [];
    public static $post_agvs = [];

    static public function get($url_name, $path, $agvs = [])
    {
        self::$agvs[$url_name] = $agvs;

        if (!strpos($path, '@')) {
            throw new ParseErrorException($path);
        }
        $tmp = explode("@", $path);
        if (strpos($tmp[0], '/')) {
            $project = explode("/", $tmp[0]);
            self::$get_url_list = array_merge($project, $tmp[1]);
        } else {
            self::$get_url_list = array_merge(array('app'), $tmp);
        }

        self::$get_url_map[$url_name] = self::$get_url_list;
    }

    public static function post($url_name, $path,$agvs=[])
    {
        self::$post_agvs[$url_name] = $agvs;
        if (!strpos($path, '@')) {
            throw new ParseErrorException($path);
        }
        $tmp = explode("@", $path);
        if (strpos($tmp[0], '/')) {
            $project = explode("/", $tmp[0]);
            self::$post_url_list = array_merge($project, $tmp[1]);
        } else {
            self::$post_url_list = array_merge(array('app'), $tmp);
        }
        self::$post_url_map[$url_name] = self::$post_url_list;
    }

    static public function parseUrl($url)
    {
        if(method() == 'get'){
            if (!isset(self::$get_url_map[$url])) {
                throw new UrlErrorException($url);
            }
            $map = self::$get_url_map[$url];
            $class_name = ucfirst($map[0]) . '\\Controller\\' . $map[1];
        }elseif(method() == 'post'){
            if (!isset(self::$post_url_map[$url])) {
                throw new UrlErrorException($url);
            }
            $map = self::$post_url_map[$url];
            $class_name = ucfirst($map[0]) . '\\Controller\\' . $map[1];
        }

        if(method() == 'get'){
            return [$class_name,$map[2],self::$agvs];
        }elseif(method() == 'post'){
            return [$class_name,$map[2],self::$post_agvs[$url]];
        }else{
            throw new UrlErrorException('路由未找到对应方法');
        }
    }

    private function parseDependenciesByClass($class_name)
    {
        static $para = array();
        $reflect = new \ReflectionClass($class_name);

        $contructer = $reflect->getConstructor();
        if ($contructer != null) {
            if(!empty($contructer->getParameters())){
                foreach ($contructer->getParameters() as $key => $parameter) {
                    if ($parameter->isDefaultValueAvailable()) {//如果参数有默认值则保持默认值
                        $para[] = $parameter->getDefaultValue();
                    } else {
                        $tmp = $parameter->getClass();
                        $tmp = $tmp === null ? null : $tmp->getName();//判断参数是一个对象还是一个变量
                        if ($tmp) {
                            $this->parseDependenciesByClass($tmp);
                        } else {
                            $para[] = $tmp;
                        }
                    }
                }
            }else {
                $para[] = $reflect->newInstance();
            }
        }

        return $para;
    }

}
