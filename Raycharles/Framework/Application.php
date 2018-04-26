<?php
/**
 * Created by PhpStorm.
 * User: qiandutianxia
 * Date: 2018/4/26
 * Time: 下午11:07
 */
namespace Raychars\Framework;

class Application{
    public function __construct()
    {
        $boot=new Bootstrap($_SERVER['DOCUMENT_ROOT']);


    }
}