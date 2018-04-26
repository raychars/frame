<?php
/**
 * Created by PhpStorm.
 * User: qiandutianxia
 * Date: 2018/4/26 0026
 * Time: 17:39
 */

namespace Raychars\Console;

use \Exception;
use Raychars\Cli\Generate;

define('EOL', chr(10));//换行符
date_default_timezone_set('Asia/Shanghai');

class Output
{
    const VERSION = '1.0.0';

    private $input;

    public function __construct($input)
    {
        $this->input = $input->getToken();
//        p($this->input);
        try {
            if (!is_array($this->input)) {
                throw new Exception($this->getDefaultMsg());
            }
            if ($this->input[0] == 'generate') {
                $obj = new Generate();

            } else {
                throw new Exception($this->getDefaultMsg());

            }
            $res = $obj->handler();
            if (!$res) {
                throw new Exception($obj->getMessage());
            }

            echo $obj->getLog();

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    private function getDefaultMsg()
    {

        $str = 'Raychars artisan version ' . self::VERSION . ' ' . date('Y-m-d H:i:s') . EOL;
        $str .= '用法：' . EOL;
        $str .= 'command [options] [arguments]' . EOL;
        $str .= '选项：' . EOL;
        $str .= str_pad('-h', 30, ' ') . '获取帮助信息' . EOL;
        $str .= str_pad('clear::cache', 30, ' ') . '清除缓存' . EOL;
        $str .= str_pad('create::controller', 30, ' ') . '生成控制器文件' . EOL;
        $str .= str_pad('create::model', 30, ' ') . '生成模型文件' . EOL;
        $str .= str_pad('create::view', 30, ' ') . '生成视图文件' . EOL;
        $str .= str_pad('create::table', 30, ' ') . '创建数据库表' . EOL;
        $str .= str_pad('generate', 30, ' ') . '生成框架必要的文件' . EOL;


        return $this->transCode($str);
    }

    private function transCode($str)
    {
        if (isset($_SERVER['LC_CTYPE']) && $_SERVER['LC_CTYPE'] == 'zh_CN.UTF-8') {
            return $str;
        }
        return iconv('utf-8', 'gbk', $str);
    }
}


