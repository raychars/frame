<?php
/**
 * Created by PhpStorm.
 * User: qiandutianxia
 * Date: 2018/4/26 0026
 * Time: 17:16
 */
namespace Raychars\Console;

class ArgvInput{
    private $tokens;

    public function __construct(array $argv = null)
    {
        if (null === $argv) {
            $argv = $_SERVER['argv'];
        }
        //把第一个参数去掉
        array_shift($argv);

        $this->tokens=$argv;
        return $this;
    }

    public function getToken(){
        return $this->tokens;
    }
}
