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
        $res=$this->mkPath('config');
        if(!$res) return false;

        $res=$this->mkPath('database');
        if(!$res) return false;

        $res=$this->mkPath('app');
        if(!$res) return false;

        $res=$this->mkPath('cache');
        if(!$res) return false;

        $res=$this->mkPath('cache/logs');
        if(!$res) return false;

        $res=$this->mkPath('cache/session');
        if(!$res) return false;

        $res=$this->mkPath('cache/backup');
        if(!$res) return false;

        $res=$this->mkPath('app/controller');
        if(!$res) return false;

        $res=$this->mkPath('app/model');
        if(!$res) return false;

        $res=$this->mkPath('app/view');
        if(!$res) return false;


        return $this->copyFile($this->baseDir);
    }

    private function copyFile($dir)
    {
        if (!is_dir($this->baseDir)) {
            $this->error = $this->baseDir . '文件夹不存在' . EOL;
            return false;
        }

        $handle = opendir($dir);

        if ($handle) {
            while (($filename = readdir($handle)) !== false) {
                //略过linux目录的名字为'.'和‘..'的文件
                if ($filename != "." && $filename != "..") {
                    //复制
                    if (copy($this->baseDir . '/' . $filename, 'config/' . $filename)) {
                        $this->log .= '复制' . 'config/' . $filename . '成功' . EOL;
                    } else {
                        $this->log .= '复制' . 'config/' . $filename . '失败' . EOL;
                    }
                }
            }
        }
        return true;
    }

    private function mkPath($folderName)
    {
        if (!is_dir($folderName)) {
            if (!mkdir($folderName,0777)) {
                $this->error = '创建'.$folderName.'文件夹失败，请手动创建' . EOL;
                return false;
            }
        }
        return true;
    }
}