<?php
/**
 * Created by PhpStorm.
 * User: qiandutianxia
 * Date: 2018/4/27 0027
 * Time: 15:38
 */

namespace Raychars\Exception;

class ParseErrorException extends ErrorException
{
    public function __construct($message = '', $line = -1)
    {
        $message = sprintf('路由解析错误: %s', $message);
        parent::__construct($message, $line);
    }

}