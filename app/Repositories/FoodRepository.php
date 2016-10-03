<?php
/**
 * Created by PhpStorm.
 * User: Takoyaki
 * Date: 2016/9/29
 * Time: 17:04
 */
namespace App\Repositories;

use App\Food;
use App\Img;

class FoodRepository
{
    public function findFoodsBySequenceAndPagesize($sequence,$pagesize)
    {
        $foods = Food::orderBy('id',$sequence)->paginate($pagesize);
        return $foods;
    }
    public function findFoodsBySequenceCidAndPagesize($sequence,$cid, $pagesize)
    {
        $foods = Food::where('category_id','=',$cid)->orderBy('id',$sequence)->paginate($pagesize);
        return $foods;
    }
    public function findFoodById($id)
    {
        $food = Food::find($id);
        return $food;
    }

    public function createFood($data)
    {
        return Food::Create([
            'name' => $data['name'],
            'price' => $data['price'],
            'category_id' => $data['category_id'],
            'floor' => $data['floor'],
            'score' => $data['score'],
        ]);
    }
}