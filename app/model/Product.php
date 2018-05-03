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
        echo "product model<br/>";
        p($test);
        $test->say();
    }

    public function index(){
        echo "product index function<br/>";
    }
}