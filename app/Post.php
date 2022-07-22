<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['content', 'photo' , 'user_id'];

    public function comments() {
        return $this->hasMany(Comment::class, 'post_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
