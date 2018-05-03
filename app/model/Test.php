<?php
/**
 * Created by PhpStorm.
 * User: qiandutianxia
 * Date: 2018/4/28
 * Time: 上午12:01
 */
namespace App\Model;

class Test{
    public function say(Product $product){
        echo "test model<br/>";
        $product->index();
    }
}