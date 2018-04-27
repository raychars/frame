<?php
/**
 * Created by PhpStorm.
 * User: qiandutianxia
 * Date: 2018/4/27 0027
 * Time: 14:52
 */

namespace Raychars\Framework;


use Raychars\Exception\ParseErrorException;

class Route
{
    public static $url_list;

    static public function get($url_name, $path)
    {
        if (!strpos($path, '@')) {
            throw new ParseErrorException($path);
        }
        $tmp=explode("@",$path);
        if(strpos($tmp[0],'/')){
            $project=explode("/",$tmp[0]);
            self::$url_list=array_merge($project,$tmp[1]);
        }else{
            self::$url_list=array_merge(array('app'),$tmp);
        }
        $obj=new self();
        $obj->parseUrl(self::$url_list);
        p(self::$url_list);
    }

    private function parseUrl($url_list){
        class_alias(ucfirst(self::$url_list).'/Controller/'.self::$url_list[1]);

    }

//    static public function __callStatic($method, $params){
//        return call_user_func_array(array(new self(), $method), $params);
//    }
}
