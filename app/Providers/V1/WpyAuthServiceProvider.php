<?php
/**
 * Created by PhpStorm.
 * User: Takoyaki
 * Date: 2016/9/23
 * Time: 17:38
 */

namespace App\Providers\V1;

use App\User;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Route;
use Dingo\Api\Contract\Auth\Provider;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class WpyAuthServiceProvider implements Provider
{
    public function authenticate(Request $request, Route $route)
    {
        // Logic to authenticate the request.
        $token = "{eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjc2OSwiaXNzIjoiaHR0cDpcL1wvb3Blbi50d3RzdHVkaW8uY29tXC9hcGlcL3YxXC9hdXRoXC90b2tlblwvcmVmcmVzaCIsImlhdCI6MTQ3MzQxMzE2NiwiZXhwIjoxNDc1MTM0NjEzLCJuYmYiOjE0NzQ1Mjk4MTMsImp0aSI6IjVhOGU0MGQ5M2VhOWI5MTljNGE0Yjk1ZDEyNjMxNWQ3In0.BB0U6VaXSNcJ4brgRHfDUdFZV4nN7BPUjXUm0ejqRRQ}";
        dump($token);
        dump(config('twt.wpy_url'));

        //验证本机上token

        $data = $this->checkWPYToken($token);
        dump($data);
        if(property_exists($data,'error_code' )){
            throw new UnauthorizedHttpException('Unable to authenticate with supplied token.');
        }else{
            $searchData = [
                'twtid' => $data->twtid,
                'twtuname' => $data->twtuname,
                'realname' => $data->realname,
                'studentid' => $data->studentid,
            ];
            $user = User::where($searchData)->first();
            /*$user = User::FindOrFail([
                'twtid' => $data->twtid,
                'twtuname' => $data->twtuname,
                'realname' => $data->realname,
                'studentid' => $data->studentid,
            ]);*/
            //$user = User::FindOrFail(1);
            dump($user);
        }
        /*dump(property_exists($data,'error_code'));
        $data = (array) $data;
        echo gettype($data);
        dump($data);*/




        //throw new UnauthorizedHttpException('Unable to authenticate with supplied token.');
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