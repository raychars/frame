<?php
/**
 * Created by PhpStorm.
 * User: qiandutianxia
 * Date: 2018/4/26
 * Time: 下午10:03
 */

namespace Raychars\Cli;

class Generate extends Base
{
    private $rootDir;
    private $baseDir;

    public function __construct()
    {
        $this->baseDir = str_replace("\\", "/", dirname(__FILE__)) . '/template/';
        $this->rootDir = $_SERVER['DOCUMENT_ROOT'];
    }

    public function handler()
    {
        if (!is_dir($this->rootDir . '/config/')) {
            if (!is_writable($this->rootDir)) {
                $this->error = '更目录文件夹不可写，请手动创建config文件夹' . EOL;
                return false;
            }
            if (!mkdir($this->rootDir . '/config',0777)) {
                $this->error = '创建config文件夹失败，请手动创建' . EOL;
                return false;
            }

            if (!is_dir($this->baseDir)) {
                $this->error = $this->baseDir . '文件夹不存在' . EOL;
                return false;
            }

        }

        return $this->copyFile($this->baseDir);
    }

    private function copyFile($dir)
    {
        $handle = opendir($dir);

        if ($handle) {
            while( ($filename = readdir($handle)) !== false )
            {
                //略过linux目录的名字为'.'和‘..'的文件
                if($filename != "." && $filename != "..")
                {
                    //复制
                    if(copy($this->baseDir.'/'.$filename,$this->rootDir.'/config/'.$filename)){
                        $this->log.='复制'.$this->rootDir.'/config/'.$filename.'成功'.EOL;
                    }else{
                        $this->log.='复制'.$this->rootDir.'/config/'.$filename.'失败'.EOL;
                    }
                }
            }
        }
        return true;
    }
}