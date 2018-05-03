<?php
/**
 * Created by PhpStorm.
 * User: qiandutianxia
 * Date: 2018/4/26
 * Time: 下午11:07
 */

namespace Raychars\Framework;

use App\Controller\IndexController;

class Application extends Container
{
    public function __construct()
    {
        //定义一些常量
        new Bootstrap();
        parent::__construct();

        Dispatcher::dispatch();

        $this->alias = $this->alias();
        $this->parseAlias();
        $this->loadRoute();
        $this->response();
        return $this->app;
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
        list($controller,$method)=Route::parseUrl($path);
        $this->app->parseMethod($controller,$method);
    }
}