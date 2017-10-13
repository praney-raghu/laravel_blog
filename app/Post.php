<?php

namespace Blog;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title','body'];

    public $timestamps = true;

    public function comments()
    {
    	return $this->hasMany('Blog\Comment');
    }
}
