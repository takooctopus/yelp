<?php
/**
 * Created by PhpStorm.
 * User: Takoyaki
 * Date: 2016/9/15
 * Time: 15:02
 */

namespace App\Http\Controllers\Api\V1;

use App\User;
use App\Transformers\V1\UserTransformer;

/**
 * Class UserController
 * @package App\Http\Controllers\Api\V1
 */
class UserController extends BaseController
{
    /**
     * @return string
     */
    public function index()
    {
        return "usersIndex";
    }

    /**
     * User resource representation.
     *
     * @Resource("Users", uri="/users/{id}")
     *
     * @Get("/users/{id}")
     * @Versions({"v1"})
     * @Request("username=foo&password=bar", contentType="application/x-www-form-urlencoded")
     * @Response(200, body={"id": 10, "username": "foo"})
     * @Parameters({
     *      @Parameter("page", description="The page of results to view.", default=1),
     *      @Parameter("limit", description="The amount of results per page.", default=10)
     * })
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $user =  User::findOrFail($id);

        /*return User::findOrFail($id);*/

        /*$user =  User::findOrFail($id);

        return $this->response->array($user->toArray());*/


        /*$user = User::findOrFail($id);

        return $this->response->item($user, new UserTransformer);*/

        /*$users = User::all();

        return $this->response->collection($users,new UserTransformer);*/

        /*$users = User::paginate(10);

        return $this->response->paginator($users, new UserTransformer);*/

        /*return $this->response->noContent();*/

        /*return $this->response->created();*/

        /*// A generic error with custom message and status code.
        return $this->response->error('This is an error.', 404);*/

        /*// A not found error with an optional message as the first parameter.
        return $this->response->errorNotFound();*/

        /*// A bad request error with an optional message as the first parameter.
        return $this->response->errorBadRequest();*/

        /*// A forbidden error with an optional message as the first parameter.
        return $this->response->errorForbidden();*/

        /*// An internal error with an optional message as the first parameter.
        return $this->response->errorInternal();*/

        /*// An unauthorized error with an optional message as the first parameter.
        return $this->response->errorUnauthorized();*/

        /*return $this->response->item($user, new UserTransformer)->withHeader('X-Foo', 'Bar');*/

        /*return $this->response->item($user, new UserTransformer)->addMeta('foo', 'bar');*/

        /*$meta['foo'] = 'bar';
        return $this->response->item($user, new UserTransformer)->setMeta($meta);*/

        /*return $this->response->item($user, new UserTransformer)->setStatusCode(200);*/

        /*$user = User::findOrFail($id);

        // Attempt to authenticate the request. If the request is not authenticated
        // then we'll hide the e-mail from the response. Only authenticated
        // requests can see other users e-mails.
        if (! app('Dingo\Api\Auth\Auth')->user()) {
            $hidden = $user->getHidden();

            $user->setHidden(array_merge($hidden, ['email']));
        }

        return $user;*/

        /*$dispatcher->attach(Input::files())->post('photos');*/
        $users = $this->api->get('users');
        return $users;
    }
}