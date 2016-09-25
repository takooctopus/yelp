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
    $api->get('token/getToken','App\Http\Controllers\Api\V1\TokenController@getToken');
    $api->get('token/checkToken','App\Http\Controllers\Api\V1\TokenController@checkToken');
    $api->get('token/refreshToken','App\Http\Controllers\Api\V1\TokenController@refreshToken');

    $api->group(['middleware' => 'api.auth'],function ($api){
        $api->get('test',function () {
            return "V1";
        });
        /*$api->post('users', function () {
            $rules = [
                'username' => ['required', 'alpha'],
                'password' => ['required', 'min:7']
            ];

            $payload = app('request')->only('username', 'password');

            $validator = app('validator')->make($payload, $rules);

            if ($validator->fails()) {
                throw new Dingo\Api\Exception\StoreResourceFailedException('Could not create new user.', $validator->errors());
            }
        });*/

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
    });

});

$dispatcher = app('Dingo\Api\Dispatcher');
Route::get('/', function () use ($dispatcher) {
    $users = $dispatcher->get('api/users/1');
    return $users;
});

