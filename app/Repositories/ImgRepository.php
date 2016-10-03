<?php
/**
 * Created by PhpStorm.
 * User: Takoyaki
 * Date: 2016/9/30
 * Time: 19:04
 */

namespace App\Repositories;

use App\Img;

class ImgRepository
{
    public function findById($id)
    {
        return Img::find($id);
    }

    public function createByUrl($url)
    {
        return Img::Create([
            'url' => $url,
        ]);
    }

    public function returnUrlById($id)
    {
        return Img::find($id)->url;
    }

    public function deleteById($id)
    {
        return Img::find($id)->delete();
    }
    public function bindBelongsToFoods($food_id,$img_ids)
    {
        $img = Img::whereIn('id',$img_ids)->update(['food_id' => $food_id]);
        return $img;
    }

    public function returnIdAndUrlsByFood_id($food_id)
    {
        return Img::where('food_id','=',$food_id)->select('id','url as imgurl')->get();
    }
}