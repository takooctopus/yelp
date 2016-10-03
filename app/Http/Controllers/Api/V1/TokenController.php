<?php
/**
 * Created by PhpStorm.
 * User: Takoyaki
 * Date: 2016/9/15
 * Time: 15:16
 */

namespace App\Http\Controllers\Api\V1;

use JWTAuth;
use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;


/**
 * Class BaseController
 * @package App\Http\Controllers\Api\V1
 */
class TokenController extends BaseController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * TokenController constructor.
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getToken(Request $request)
    {
        // grab credentials from the request
        $wpy_token = $request->only('wpy_token')['wpy_token'];
        /*$wpy_token = $wpy_token['wpy_token'];*/
        if (empty($wpy_token)) {
            return $this->build_parameters_error();
        }
        $item = $this->checkWPYToken($wpy_token);

        if ($item->error_code){
            return $this->build_error("微北洋Token验证SSO失败",401);
        }

        $twtid = $item->twtid;

        $user = $this->userRepository->findByTwtidOrCreate($twtid);
        $token = JWTAuth::fromUser($user);

        return $this->build_response(['token' => $token]);

        /*$credentials = ['twtid' => $item->twtid,
                        'twtuname' => $item->twtuname,
                        'realname' => $item->realname,
                        'studentid' => $item->studentid,];
        return $credentials;*/

        //$user = User::where($credentials)->firstOrFail();

        //$token = JWTAuth::fromUser($user);

        // all good so return the token
        //return response()->json(compact('token'));

        /*return json_encode($credentials);
        $credentials = $request->only('wpy_token');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));*/
    }
    public function checkToken()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return $this->build_error('user_not_found',404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return $this->build_error('token_expired',$e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return $this->build_error('token_invalid',$e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return $this->build_error('token_absent',$e->getStatusCode());

        }

        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }

    public function refreshToken()
    {
        try {
            $newtoken = JWTAuth::parseToken()->refresh();
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return $this->build_error('token expired', $e->getStatusCode());
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return $this->build_error('token invalid', $e->getStatusCode());
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return $this->build_error('token absent', $e->getStatusCode());
        }
        return $this->build_response($newtoken);
    }

    private function _request($url, $postData = null, $header = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($header) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }

        if ($postData) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        }

        $data = curl_exec($ch);
        curl_close($ch);

        return json_decode($data);
    }

    private function checkWPYToken ($token) {
        //$_CONFIG['twt']['wpy_url'] = 'http://open.twtstudio.com/api/v2/auth/self';
        //global $_CONFIG;
        return $this->_request(config('twt.wpy_url'), null, array('Authorization: Bearer ' . $token));
    }
}