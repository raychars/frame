<?php
/**
 * Created by PhpStorm.
 * User: qiandutianxia
 * Date: 2018/4/23 0023
 * Time: 13:50
 */

namespace Raychars\Upload;

class UploadFile
{
    protected $fileType = array('zip', 'rar', 'pdf', 'mp4', 'mp3', 'avi', 'rmvb');//允许的文件后缀
    protected $tmpPath;//临时目录
    protected $blobNum;//当前分片数
    protected $totalBlobNum;//总共分片数
    protected $fileName;//保存的文件名称
    protected $filePath = './upload';//保存的文件路径
    protected $error = '';//错误信息
    protected $maxSize=2097152;//分片大小最大为2M;
    protected $fileExt;
    protected $fileKey;

    public function __construct($tmpPath, $fileName, $fileKey = 'filedata', $blobNum = 0, $totalBlobNum = 0)
    {
        $this->tmpPath = $tmpPath;
        $this->blobNum = $blobNum;
        $this->totalBlobNum = $totalBlobNum;
        $this->fileName = $fileName;
        $this->fileKey = $fileKey;
    }

    /**
     * 上传
     * @throws \Exception
     */
    public function upload()
    {
        $this->checkFileExt();
        $this->checkFileSize();
        $this->moveFile();
        $this->fileMerge();
    }

    /**
     * 保存临时文件
     */
    private function moveFile()
    {
        $this->touchDir();
        $filename = $this->filePath . '/' . $this->fileName . '.' . $this->fileExt . '__' . $this->blobNum;
        move_uploaded_file($this->tmpPath, $filename);
    }

    /**
     * 检查文件格式
     */
    private function checkFileExt()
    {
        $fileExt = strtolower(strrchr($this->tmpPath, '.')); //文件后缀
        $fileExt = trim($fileExt, '.');
        if (!in_array($fileExt, $this->fileType)) {
            throw new \Exception('文件格式错误，允许格式为' . implode(",", $this->fileType));
        }
        $this->fileExt = $fileExt;
    }

    public function checkFileSize()
    {
        var_dump($_FILES);
        if (isset($_FILES[$this->fileKey]) && $_FILES[$this->fileKey]['size'] > $this->maxSize) {
            $size = round(($this->maxSize / 1024) / 1024, 0);
            throw new \Exception('文件大小超出限制，允许大小为', $size);
        }
    }

    /**
     * 创建文件夹
     * @return bool
     */
    private function touchDir()
    {
        if (!file_exists($this->filePath)) {
            mkdir($this->filePath, 0777);
        }
    }

    /**
     * 合并分片文件
     */
    private function fileMerge()
    {
        if ($this->blobNum == $this->totalBlobNum) {
            for ($i = 0; $i < $this->totalBlobNum; $i++) {
                $fp = fopen($this->filePath . '/' . $this->fileName . '.' . $this->fileExt, 'a+');
                @flock($fp, LOCK_EX);
                $tmp = $this->filePath . '/' . $this->fileName . '.' . $this->fileExt . '__' . $i;
                $fp2 = @fopen($tmp, "rb");
                @fwrite($fp, fread($fp2, filesize($tmp)));
                @flock($fp, LOCK_UN);
                @fclose($fp);
                @fclose($fp2);
                @unlink($tmp);
            }
            $this->deleteFileBlob();
        }
    }

    /**
     * 删除分片文件
     */
    private function deleteFileBlob()
    {
        for ($i = 0; $i <= $this->totalBlobNum; $i++) {
            @unlink($this->filePath . '/' . $this->fileName . '.' . $this->fileExt . '__' . $i);
        }
    }

    /**
     * 返回上传结果
     * @return mixed
     */
    public function getFile()
    {
        $data = array();
        if ($this->blobNum == $this->totalBlobNum) {
            if (file_exists($this->filePath . '.' . $this->fileExt . '/' . $this->fileName)) {
                $data['code'] = 2;
                $data['msg'] = 'success';
                $data['file_path'] = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['DOCUMENT_URI']) . str_replace('.', '', $this->filePath) . '/' . $this->fileName . '.' . $this->fileExt;
            }
        } else {
            if (file_exists($this->filePath . '/' . $this->fileName . '.' . $this->fileExt . '__' . $this->blobNum)) {
                $data['code'] = 1;
                $data['msg'] = 'waiting for all';
                $data['file_path'] = '';
            }
        }
        return $data;
    }

    /**
     * 设置上传文件类型
     * @param $type
     * @param bool $model 默认为false，表示合并，true这单独设置
     */
    public function extendFileType($type, $model = false)
    {
        if ($model && is_array($type)) {
            $this->fileType = $type;
        } else {
            if (is_array($type)) {
                $this->fileType = array_merge($this->fileType, $type);
                $this->fileType = array_unique($this->fileType);
            } else {
                $this->fileType[] = $type;
            }
        }
    }

    //设置分片大小
    public function setFileMaxSize($number)
    {
        $this->maxSize = $number;
    }

    //设置保存路径
    public function setSavePath($dir)
    {
        $this->filePath = $dir;
    }
}
