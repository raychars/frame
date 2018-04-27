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

    public function __construct()
    {

        $this->root = ROOT_PATH;
        $filename = ROOT_PATH . '/env';
        $handle = fopen($filename, "r");
        while (!feof($handle)) {
            $buffer = fgets($handle, 4096);
            $item = trim($buffer);
            if ($item) {
                putenv($item);
            }
        }
        fclose($handle);

        $this->initAfter();
    }

    private function initAfter()
    {
        define('LOG_PATH', $this->root . '/cache/logs');
        define('SESSION_PATH', $this->root . '/cache/logs');
        define('BACKUP_PATH', $this->root . '/cache/logs');

    }


}