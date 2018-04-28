<?php
/**
 * Created by PhpStorm.
 * User: qiandutianxia
 * Date: 2018/4/27
 * Time: 下午10:41
 */

namespace App\Controller;

use App\Model\Product;
use App\Model\Test;


class IndexController
{

//    public function __construct(Test $test, Product $product)
//    {
//        p($test->say());
//    }


    public function index()
    {
        p($_GET);
    }

    public function post()
    {
        echo "22";
    }
}