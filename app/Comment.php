<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id', 'content', 'user_id'];

    public function post() {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
