<?php
/**
 * Created by PhpStorm.
 * User: Takoyaki
 * Date: 2016/9/29
 * Time: 17:32
 */
namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Dflydev\ApacheMimeTypes\PhpRepository;

class  UploadsManager
{
    protected $disk;
    protected $mimeDetect;

    /**
     * UploadsManager constructor.
     */
    public function __construct(PhpRepository $mimeDetect)
    {
        $this->disk = Storage::disk(config('yelp.uploads.storage'));
        $this->mimeDetect = $mimeDetect;
    }

    /**
     * Sanitize the folder name
     */
    protected function cleanFolder($folder)
    {
        return '/' . trim(str_replace('..', '', $folder), '/');
    }

    /**
     * 创建新目录
     */
    public function createDirectory($folder)
    {
        $folder = $this->cleanFolder($folder);

        if ($this->disk->exists($folder)) {
            return false;
        }

        return $this->disk->makeDirectory($folder);
    }

    /**
     * 保存文件
     */
    public function saveFile($path, $content)
    {
        $path = $this->cleanFolder($path);

        if ($this->disk->exists($path)) {
            return "File already exists.";
        }

        return $this->disk->put($path, $content);
    }

    /**
     * 返回文件MIME类型
     */
    public function fileMimeType($path)
    {
        return $this->mimeDetect->findType(
            pathinfo($path, PATHINFO_EXTENSION)
        );
    }



}