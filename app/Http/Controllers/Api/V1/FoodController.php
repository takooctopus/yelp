<?php
/**
 * Created by PhpStorm.
 * User: Takoyaki
 * Date: 2016/9/15
 * Time: 15:02
 */

namespace App\Http\Controllers\Api\V1;

use App\Food;
use App\Http\Requests\AddFoodRequest;
use App\Http\Requests\Request;
use App\Repositories\FoodRepository;
use App\Repositories\ImgRepository;

/**
 * Class FoodController
 * @package App\Http\Controllers\Api\V1
 */
class FoodController extends BaseController
{
    private $sequence = array('asc','desc');
    /**
     * @var FoodRepository
     */
    private $foodRepository;
    /**
     * @var ImgRepository
     */
    private $imgRepository;

    /**
     * FoodController constructor.
     */
    public function __construct(FoodRepository $foodRepository,ImgRepository $imgRepository)
    {
        $this->foodRepository = $foodRepository;
        $this->imgRepository = $imgRepository;
    }

    public function foodsAll($sequence,$pagesize=30)
    {
        if (!in_array($sequence, $this->sequence)){
            return $this->build_parameters_error();
        }
        $foods = $this->foodRepository->findFoodsBySequenceAndPagesize($sequence, $pagesize);
        return $this->build_pagination($foods);
    }
    public function foodsCategoryAll($sequence,$cid,$pagesize=30)
    {
        if (!in_array($sequence, $this->sequence)){
            return $this->build_parameters_error();
        }
        $foods = $this->foodRepository->findFoodsBySequenceCidAndPagesize($sequence,$cid,$pagesize);
        return $this->build_pagination($foods);
    }

    public function foodDetail($food_id)
    {
        $food = $this->foodRepository->findFoodById($food_id);
        return $this->build_response($food);
    }

    public function addFood(AddFoodRequest $request)
    {
        $data['name'] = $request->get('name');
        $data['price'] = $request->get('price');
        $data['category_id'] = $request->get('category_id');
        $data['floor'] = $request->get('floor');
        $data['score'] = $request->get('score');
        $result = $this->foodRepository->createFood($data);
        if(!$result){
            $this->build_error("Create Model Error!");
        }
        $food_id = $result->id;
        $imgs= $request->get('imgs');

        //return gettype($imgs);
        $result = $this->imgRepository->bindBelongsToFoods($food_id,$imgs);
        if(!$result){
            $this->build_error("Img Model Update Error!");
        }
        //$imgurls = $this->imgRepository->returnIdAndUrlsByFood_id($food_id);
        $response['id'] = $food_id;
        return $this->build_response($response);
    }

}