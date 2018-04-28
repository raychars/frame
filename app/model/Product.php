<?php
/**
 * Created by PhpStorm.
 * User: qiandutianxia
 * Date: 2018/4/28 0028
 * Time: 14:25
 */
namespace App\Model;

class Product{
    public function __construct(Test $test)
    {
        echo "product model";
        $test->say();
    }
}