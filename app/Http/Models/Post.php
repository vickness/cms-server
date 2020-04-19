<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $primaryKey = 'pid';

    // 关联User表
    public function user() {
        return $this->belongsTo(User::class, 'uid')->select('uid', 'userName', 'nickName', 'avatarUrl');
    }
}
