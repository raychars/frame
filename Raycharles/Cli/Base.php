<?php
/**
 * Created by PhpStorm.
 * User: qiandutianxia
 * Date: 2018/4/26
 * Time: 下午10:26
 */
namespace Raychars\Cli;

class Base{
    protected $error;
    protected $log;

    public function getMessage(){
        return $this->error;
    }

    public function getLog(){
        return $this->log;
    }
}