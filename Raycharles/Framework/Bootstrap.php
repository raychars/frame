<?php
/**
 * Created by PhpStorm.
 * User: qiandutianxia
 * Date: 2018/4/26
 * Time: 下午11:10
 */

namespace Raychars\Framework;

class Bootstrap
{
    private $root;

    public function __construct($root_path)
    {
        $this->root = $root_path . '../';
        $filename = $this->root . 'env';
        $handle = fopen($filename, "r");
        while (!feof($handle)) {
            $buffer = fgets($handle, 4096);
            $item = trim($buffer);
            if ($item) {
                putenv($item);
            }
        }
        fclose($handle);
    }
}