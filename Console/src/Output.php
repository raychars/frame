<?php
/**
 * Created by PhpStorm.
 * User: qiandutianxia
 * Date: 2018/4/26 0026
 * Time: 17:39
 */
namespace Raychars\Console;

use \Exception;

define('EOL',chr(10));//换行符

class Output{
    const VERSION='1.0.0';

    private $input;

    public function __construct($input)
    {
        $this->input=$input->getToken();
//        p($this->input);
        try{
            if(!is_array($this->input)){
                throw new Exception($this->getDefaultMsg());
            }
            switch ($this->input){
                default:
                    throw new Exception($this->getDefaultMsg());
            }
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    private function getDefaultMsg(){
        $str='Raychars artisan version '.self::VERSION.' '.date('Y-m-d H:i:s').EOL;
        $str.='用法：'.EOL;
        $str.='command [options] [arguments]'.EOL;

        return $this->transCode($str);
    }

    private function transCode($str){
        return iconv('utf-8','gbk',$str);
    }
}


