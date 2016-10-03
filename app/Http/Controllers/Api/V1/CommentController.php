<?php
/**
 * Created by PhpStorm.
 * User: Takoyaki
 * Date: 2016/9/15
 * Time: 15:02
 */

namespace App\Http\Controllers\Api\V1;
use App\Http\Requests\AddCommentRequest;
use App\Http\Requests\Request;

use App\Repositories\CommentRepository;
use App\Repositories\ImgRepository;
use App\Repositories\LikeRepository;


class CommentController extends BaseController
{
    /**
     * @var CommentRepository
     */
    private $commentRepository;
    /**
     * @var ImgRepository
     */
    private $imgRepository;
    /**
     * @var LikeRepository
     */
    private $likeRepository;

    /**
     * CommentController constructor.
     */
    public function __construct(CommentRepository $commentRepository,ImgRepository $imgRepository,LikeRepository $likeRepository)
    {
        $this->commentRepository = $commentRepository;
        $this->imgRepository = $imgRepository;
        $this->likeRepository = $likeRepository;
    }

    public function addComment(AddCommentRequest $request)
    {
        $data['food_id'] = $request->get('food_id');
        $data['vote'] = $request->get('vote');
        $data['content'] = $request->get('content');

        $imgs = $request->get('imgs');

        $result = $this->commentRepository->createComment($data);
        if(!$result){
            $this->build_error("Create Comment Model Error!");
        }
        $comment_id = $result->id;

        //return gettype($imgs);
        $result = $this->imgRepository->bindBelongsToFoods($comment_id,$imgs);
        if(!$result){
            return $this->build_error("Img Model Update Error!");
        }
        //$imgurls = $this->imgRepository->returnIdAndUrlsByFood_id($food_id);
        $response['id'] = $comment_id;
        return $this->build_response($response);
    }

    public function commentdetail($comment_id)
    {
        $comment = $this->commentRepository->findCommentById($comment_id);
        return $this->build_response($comment);
    }

    public function addLike($comment_id)
    {
        $data['comment_id'] = $comment_id;
        $user = $this->auth->user();
        $data['user_id'] = $user->id;

        $result = $this->likeRepository->createLike($data);
        if(!$result){
            return $this->build_error("Create Comment Model Error!");
        }
        return $this->build_response();
    }

    public function resLike($comment_id)
    {
        $data['comment_id'] = $comment_id;
        $user = $this->auth->user();
        $data['user_id'] = $user->id;

        $result = $this->likeRepository->deleteLike($data);

        if(!$result){
            return $this->build_error("delete error");
        }
        return $this->build_response();

    }
    public function isLike($comment_id)
    {
        $data['comment_id'] = $comment_id;
        $user = $this->auth->user();
        $data['user_id'] = $user->id;

        $result = $this->likeRepository->findLike($data);

        if(!$result){
            return $this->build_response("0");
        }
        return $this->build_response("1");
    }
}