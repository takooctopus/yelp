<?php
/**
 * Created by PhpStorm.
 * User: Takoyaki
 * Date: 2016/9/30
 * Time: 19:04
 */

namespace App\Repositories;

use App\Like;

class LikeRepository
{
    public function createLike($data)
    {
        return Like::Create([
            'comment_id' => $data['comment_id'],
            'user_id' => $data['user_id'],
        ]);
    }

    public function deleteLike($data)
    {
        return Like::where('comment_id','=',$data['comment_id'])
                    ->orWhere($data['user_id'])->delete();
    }

    public function findLike($data)
    {
        return Like::where('comment_id','=',$data['comment_id'])
            ->orWhere($data['user_id'])->first();
    }
    
}