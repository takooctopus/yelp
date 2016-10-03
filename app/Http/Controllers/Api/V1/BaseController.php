<?php
/**
 * Created by PhpStorm.
 * User: Takoyaki
 * Date: 2016/9/15
 * Time: 15:16
 */

namespace App\Http\Controllers\Api\V1;

use Dingo\Api\Routing\Helpers;
use App\Traits\ResponseBuilder;
use Illuminate\Routing\Controller;

/**
 * Class BaseController
 * @package App\Http\Controllers\Api\V1
 */
class BaseController extends Controller
{
    use ResponseBuilder;
    use Helpers;
}