<?php
/**
 * Created by PhpStorm.
 * User: qiandutianxia
 * Date: 2018/4/26
 * Time: 下午9:25
 */

//调试
if (!function_exists('p')) {
    function p($arr)
    {
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
    }
}


//获取配置文件
if (!function_exists('env')) {
    function env($key, $default = null)
    {
        $value = getenv($key);
        $value = trim($value);
        if ($value == 'true') {
            return true;
        }
        if ($value == 'false') {
            return false;
        }
        if(empty($value)){
            return $default;
        }
        return $value;
    }
}
