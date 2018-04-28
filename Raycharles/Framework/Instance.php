<?php
/**
 * Created by PhpStorm.
 * User: qiandutianxia
 * Date: 2018/4/28 0028
 * Time: 14:13
 */
namespace Raychars\Framework;

class Instance{

    static private $instance=array();

    //防止直接创建对象
    private function __construct($config){
        return $config;
    }

    //防止克隆对象
    private function __clone(){}

    static public function getInstance($config){
        //判断$instance是否是Uni的对象
        if(!self::$instance[$config] instanceof self){
            self::$instance[$config] = new self($config);
        }
        return self::$instance[$config];
    }
}