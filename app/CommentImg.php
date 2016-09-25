<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentImg extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'comment_imgs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['comment_id', 'url'];

}
