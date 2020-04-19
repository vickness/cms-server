<?php

namespace App\Http\Controllers;

use App\Http\Config\Verify;
use App\Http\Models\Post;
use App\Http\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    // 查询用户
    public function info(Request $request) {

        $uid = $request->input('uid');
        if (!$uid) {
            return $this->error(400005);
        }
        $user = User::find($uid);
        return $this->success($user);
    }

    // 查询列表
    public function list(Request $request) {
        $users = User::all();
        return $this->success($users);
    }





    // 修改密码

}
