<?php
/**
 * Created by PhpStorm.
 * User: qiandutianxia
 * Date: 2018/4/26
 * Time: 下午11:13
 */
header("Content-type:text/html;charset=utf-8");
require '../vendor/autoload.php';

try{
    $app=new \Raychars\Framework\Application();
}catch(\Raychars\Exception\ErrorException $e){
    echo $e->getError();
}


