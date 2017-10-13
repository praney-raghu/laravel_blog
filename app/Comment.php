<?php

namespace Blog;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['name','body'];

    public $timestamps = true;

    public function posts()
    {
    	return $this->hasOne('Blog\Post');
    }
}
