<?php
/**
 * Created by PhpStorm.
 * User: Takoyaki
 * Date: 2016/9/30
 * Time: 19:04
 */

namespace App\Repositories;

use App\Comment;

class CommentRepository
{
    public function createComment($data)
    {
        return Comment::Create([
            'food_id' => $data['food_id'],
            'vote' => $data['vote'],
            'content' => $data['content'],
        ]);
    }

    public function findCommentById($id)
    {
        $comment = Comment::find($id);
        return $comment;
    }
}