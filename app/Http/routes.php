<?php


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

$api = app('Dingo\Api\Routing\Router');



$api->version('v1', function ($api) {
    $api->get('test',function (){

    });

    $api->get('token/getToken','App\Http\Controllers\Api\V1\TokenController@getToken');
    $api->get('token/checkToken','App\Http\Controllers\Api\V1\TokenController@checkToken');
    $api->get('token/refreshToken','App\Http\Controllers\Api\V1\TokenController@refreshToken');

    $api->post('upload/image', 'App\Http\Controllers\Api\V1\UploadController@uploadImage');
    $api->delete('upload/image', 'App\Http\Controllers\Api\V1\UploadController@deleteImage');

    $api->get('image/{id}','App\Http\Controllers\Api\V1\ImgController@showImage');

    $api->post('food/addFood','App\Http\Controllers\Api\V1\FoodController@addFood');
    $api->get('foods/{sequence}/all/pagesize/{pagesize}','App\Http\Controllers\Api\V1\FoodController@foodsAll')/*->where('sequence', '');*/;
    $api->get('foods/{sequence}/category/{cid}/all/pagesize/{pagesize}','App\Http\Controllers\Api\V1\FoodController@foodsCategoryAll');
    $api->get('food/{food_id}/detail','App\Http\Controllers\Api\V1\FoodController@foodDetail');

    $api->post('comment/addComment','App\Http\Controllers\Api\V1\CommentController@addComment');//comment 的图片上传需要做
    $api->get('comment/{comment_id}/detail','App\Http\Controllers\Api\V1\CommentController@commentDetail');

    $api->post('comment/{$comment_id}/addLike','App\Http\Controllers\Api\V1\CommentController@addLike');
    $api->post('comment/{$comment_id}/resLike','App\Http\Controllers\Api\V1\CommentController@resLike');
    $api->post('comment/{$comment_id}/isLike','App\Http\Controllers\Api\V1\CommentController@isLike');

    /*$api->group(['middleware' => 'api.auth'],function ($api){
        $api->get('test',function () {
            return "V1";
        });




        $api->get('users', 'App\Http\Controllers\Api\V1\UserController@index');
        $api->get('users/{id}', 'App\Http\Controllers\Api\V1\UserController@show');

        $api->get('foods/{sequence}/all','App\Http\Controllers\Api\V1\FoodController@foodsAll');
        $api->get('foods/{sequence}/{cid}/all','App\Http\Controllers\Api\V1\FoodController@foodsCategoryAll');
        $api->get('food/{food_id}','App\Http\Controllers\Api\V1\FoodController@foodDetail');

        $api->post('food/addFood','App\Http\Controllers\Api\V1\FoodController@addFood');

        $api->post('comment/{id}/addLike','App\Http\Controllers\Api\V1\CommentController@addLike');
        $api->post('comment/{id}/resLike','App\Http\Controllers\Api\V1\CommentController@resLike');

        $api->post('comment/addComment','App\Http\Controllers\Api\V1\CommentController@addComment');


        //$api->get('users/{id}', ['as' => 'users.index', 'uses' => 'Api\V1\UserController@show']);
    });*/

});

$dispatcher = app('Dingo\Api\Dispatcher');
Route::get('/', function () use ($dispatcher) {
    $users = $dispatcher->get('api/users/1');
    return $users;
});

