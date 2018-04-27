<?php
/**
 * Created by PhpStorm.
 * User: qiandutianxia
 * Date: 2018/4/27
 * Time: 下午10:41
 */

namespace App\Controller;

use App\Model\Test;

class IndexController
{
    public function index(Test $test)
    {
        p($test->say());
    }

    public function post(){
        echo "22";
    }
}