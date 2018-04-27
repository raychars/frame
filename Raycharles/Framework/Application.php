<?php
/**
 * Created by PhpStorm.
 * User: qiandutianxia
 * Date: 2018/4/26
 * Time: 下午11:07
 */

namespace Raychars\Framework;

use App\Controller\IndexController;

class Application
{
    public $alias;//类别名

    public function __construct()
    {
        //定义一些常量
        new Bootstrap();

        Dispatcher::dispatch();

        $this->alias = $this->alias();
        $this->parseAlias();
        $this->loadRoute();
        $this->response();
    }

    public function alias()
    {
        $alias_path = ROOT_PATH . '/config/alias.php';
        if (file_exists($alias_path)) {
            $list = require_once $alias_path;
            return isset($list['alias']) ? $list['alias'] : '';
        }
        return array();
    }

    public function parseAlias(){
        if(is_array($this->alias)){
            foreach ($this->alias as $key=>$value){
                class_alias($value, $key);
            }
        }
    }

    public function loadRoute(){
        $route_path = ROOT_PATH . '/config/route.php';
        if (file_exists($route_path)) {
            $list = require_once $route_path;
            return isset($list['alias']) ? $list['alias'] : '';
        }
        return array();
    }

    public function response(){
        $path=isset($_SERVER['REDIRECT_URL'])?$_SERVER['REDIRECT_URL']:'/';
        
        Route::parseUrl($path);
    }
}