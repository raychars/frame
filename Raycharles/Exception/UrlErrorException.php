<?php
/**
 * Created by PhpStorm.
 * User: qiandutianxia
 * Date: 2018/4/27
 * Time: 下午11:17
 */
namespace Raychars\Exception;

class UrlErrorException extends ErrorException{
    public function __construct($message = '', $line = -1)
    {
        $message = sprintf('URL不存在: %s', $message);
        parent::__construct($message, $line);
    }
}