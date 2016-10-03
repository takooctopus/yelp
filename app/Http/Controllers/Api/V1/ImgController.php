<?php
/**
 * Created by PhpStorm.
 * User: Takoyaki
 * Date: 2016/9/15
 * Time: 15:02
 */

namespace App\Http\Controllers\Api\V1;
use App\Http\Requests\Request;

use Intervention\Image\Facades\Image;
use App\Repositories\ImgRepository;

/**
 * Class FoodController
 * @package App\Http\Controllers\Api\V1
 */
class ImgController extends BaseController
{
    /**
     * @var ImgRepository
     */
    private $imgRepository;

    /**
     * ImgController constructor.
     */
    public function __construct(ImgRepository $imgRepository)
    {
        $this->imgRepository = $imgRepository;
    }

    public function showImage($id)
    {
        $img_url = $this->imgRepository->returnUrlById($id);
        $img = Image::make($img_url);
        return $img->response();
    }
}