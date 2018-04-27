<?php
/**
 * Created by PhpStorm.
 * User: qiandutianxia
 * Date: 2018/4/27 0027
 * Time: 15:44
 */
namespace Raychars\Exception;

class ErrorException extends \Exception{

    public function getError(){
        $str='<br/>'.$this->message.'<br/>';
        $str.='错误代码：'.$this->code.'<br/>';
        $str.='错误文件：'.$this->file.'<br/>';
        $str.='错误行：'.$this->line.'<br/>';
        return $str;
    }
}