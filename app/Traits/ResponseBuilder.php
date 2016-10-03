<?php
/**
 * Created by PhpStorm.
 * User: Takoyaki
 * Date: 2016/9/29
 * Time: 16:42
 */

namespace App\Traits;

/**
 * Class ResponseBuilder
 * @package App\Traits
 */
trait ResponseBuilder
{
    private $response_formatter = [
        'errCode' => 0 ,
        'errMsg' => '',
        'data' => null ,
    ];

    /**
     * @param null $response
     * @param int $errCode
     * @param int $status
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function build_response($response = null , $errCode = 0 , $status = 200)
    {
        $this->response_formatter['errCode'] = $errCode;
        $this->response_formatter['data'] = $response;
        return response($this->response_formatter, $status);
    }

    public function build_pagination($response, $errCode = 0 , $status = 200)
    {
        $this->response_formatter = $response;
        $this->response_formatter['errCode'] = 0;
        $this->response_formatter['errMsg'] = '';
        return response($this->response_formatter, $status);
    }

    /**
     * @param $errMsg
     * @param int $status
     * @param int $errCode
     * @param null $debug
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function build_error($errMsg, $status = 400 , $errCode = -1 , $debug = null)
    {
        $this->response_formatter['errCode'] = $errCode;
        $this->response_formatter['errMsg'] = $errMsg;
        if ( !empty($debug) && Config::get(app.debug)) {
            $this->response_formatter['data'] = $debug;
        }
        return response($this->response_formatter, $status);
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function build_parameters_error()
    {
        return $this->build_error('参数错误',400,30001);
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function build_not_found()
    {
        return $this->build_error('404 not found',404,40001);
    }
}