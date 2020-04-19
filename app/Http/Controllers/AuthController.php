<?php

namespace App\Http\Controllers;

use App\Http\Config\Verify;
use App\Http\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // 登录
    public function login(Request $request) {

        //校验参数
        $validate = Verify::login($request);
        if ($validate->fails()) {
            return $this->verifyFails($validate);
        }

        //获取指定参数
        $userName = $request->input('userName');
        $passWord = $request->input('passWord');

        //查找用户
        $user = User::where('userName', $userName)->first();
        if (!$user) {
            return $this->error(200001);
        }
        if ($user->passWord != $passWord) {
            return $this->error(200004);
        }
        $user['api_token'] = Str::random(60);
        $result = $user->save();
        if (!$result) {
            return $this->error(100004);
        }
        return $this->success($user);
    }


    // 注册
    public function register(Request $request) {

        //校验参数
        $validate = Verify::register($request);
        if ($validate->fails()) {
            return $this->verifyFails($validate);
        }

        //获取指定参数
        $userName = $request->input('userName');
        $passWord = $request->input('passWord');

        $user = new User;
        $user['userName'] = $userName;
        $user['passWord'] = $passWord;
        $user['api_token'] = '';
        $user['nickName'] = '';
        $user['avatarUrl'] = '';
        $result = $user->save();
        if (!$result) {
            return $this->error(100004);
        }
        return $this->success($user);
    }


    // 重置密码

    // 发送验证码

}
