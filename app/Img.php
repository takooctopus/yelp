<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Img extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'imgs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['food_id', 'url'];
}
