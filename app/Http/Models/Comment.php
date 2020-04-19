<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $primaryKey = 'mid';

    // 关联User表
    public function user() {
        return $this->belongsTo(User::class, 'uid')->select('uid', 'userName', 'nickName', 'avatarUrl');
    }

    // 关联Reply表
    public function replies() {
        return $this->hasMany(Reply::class, 'mid')->with('user');
    }
}
