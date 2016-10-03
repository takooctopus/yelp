<?php
/**
 * Created by PhpStorm.
 * User: Takoyaki
 * Date: 2016/9/29
 * Time: 17:04
 */
namespace App\Repositories;

use App\User;

class UserRepository
{
    public function findByTwtid($twtid)
    {
        return User::where('twtid','=',$twtid)->first();
    }

    public function findByTwtidOrCreate($userData)
    {
        return User::firstOrCreate([
            'twtid' => $userData->twtid,
            'twtuname' => $userData->twtuname,
            'realname' => $userData->realname,
            'studentid' => $userData->studentid,
        ]);
    }
}