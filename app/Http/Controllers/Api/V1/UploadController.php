<?php
/**
 * Created by PhpStorm.
 * User: Takoyaki
 * Date: 2016/9/15
 * Time: 15:02
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Request;
use App\Repositories\ImgRepository;
use App\Services\UploadsManager;
//use Symfony\Component\Console\Input\Input;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Input;
use Webpatser\Uuid\Uuid;
use Intervention\Image\Facades\Image;

use App\Http\Requests\UploadImageRequest;
use App\Http\Requests\DeleteImageRequest;
use Illuminate\Support\Facades\File;



class UploadController extends BaseController
{
    /**
     * @var UploadsManager
     */
    private $manager;
    /**
     * @var ImgRepository
     */
    private $imgRepository;

    /**
     * UploadController constructor.
     */
    public function __construct(UploadsManager $manager, ImgRepository $imgRepository)
    {
        $this->manager = $manager;
        $this->imgRepository = $imgRepository;
    }

    public function index(Request $request)
    {

    }

    public function uploadImage(UploadImageRequest $request)
    {
        $folder = "";
        $new_folder = "Image";
        $folder = $folder.'/'.$new_folder;

        $result = $this->manager->createDirectory($folder);

        if ($result === true) {

        }

        $image = Input::file('image');
        //$fileName = $image->getClientOriginalName();
        $fileName = Uuid::generate().'.'.$image->getClientOriginalExtension();
        $path = rtrim(config('yelp.uploads.savepath').str_finish($folder, '/'),'/');
        //return $path;
        $imagePath = $image->move($path, $fileName);
        $result = Image::make($imagePath)->resize(300, 200)->save();
        if(!$result){
            $this->build_error("Image create error!!!");
        }
        $result = $this->imgRepository->createByUrl($imagePath);
        if(!$result){
            $this->build_error("Image Model create error!!!");
        }
        $img = $this->imgRepository->findById($result->id);
        return $this->build_response($img);






        //$result = Image::make($image)->resize(200, 200)->save($path);

        /*$file = $_FILES['image'];
        $image = $request->file('image');
        $fileName = Uuid::generate();
        $mimetype = $image->getMimeType();
        $mime = explode('/',$mimetype);

        $path = str_finish($folder, '/') . $fileName . "." . $mime[1];
        //$path = str_finish($folder, '/') . $fileName;

        $result = Image::make($image->getRealPath())->resize(200, 200)->save($path);
        return $result;
        //$content = File::get($file['tmp_name']);
        //$result = $this->manager->saveFile($path, $content);

        if ($result === true) {
            //$img = $this->imgRepository->createByUrl($path);
            //return $this->build_response($img);
        }*/
    }

    /**
     * 删除文件
     */
    public function deleteImage(DeleteImageRequest $request)
    {

        $img_id = $request->get('img_id');
        $img_url = $this->imgRepository->returnUrlById($img_id);
        if(!$img_url){
            return $this->build_error("Img Model Not exist! ");
        }

        $result = File::Delete($img_url);
        if (!$result){
            $result = $this->imgRepository->deleteById($img_id);
            if (!$result){
                return $this->build_error("Delete Model Error!!!");
            }
            return $this->build_error("Img Not exist! ");
        }
        $result = $this->imgRepository->deleteById($img_id);
        if (!$result){
            return $this->build_error("Delete Model Error!!!");
        }
        return $this->build_response();
        
        /*$result = file_exists($img_url);
        return (int)($result);*/

        /*$path = $request->get('folder').'/'.$del_file;

        $result = $this->manager->deleteFile($path);

        if ($result === true) {
            return redirect()
                ->back()
                ->withSuccess("File '$del_file' deleted.");
        }

        $error = $result ? : "An error occurred deleting file.";

        $del_folder = $request->get('del_folder');
        $folder = $request->get('folder').'/'.$del_folder;

        $result = $this->manager->deleteDirectory($folder);

        if ($result === true) {
            return redirect()
                ->back()
                ->withSuccess("Folder '$del_folder' deleted.");
        }*/
    }
}