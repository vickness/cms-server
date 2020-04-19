<?php
/**
 * Created by IntelliJ IDEA.
 * User: visen
 * Date: 2020-01-31
 * Time: 14:16
 */

namespace App\Http\Config;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Verify
{
    // 登录参数校验
    public static function login(Request $request) {
        return Validator::make($request->all(), [
            'userName' => 'required|min:6|max:25',
            'passWord' => 'required|min:6|max:25',
        ], [
            'userName.required' => '用户名不能为空',
            'userName.min' => '用户名不能少于6位',
            'userName.max' => '用户名不能多于25位',
            'passWord.required' => '密码不能为空',
            'passWord.min' => '密码不能少于6位',
            'passWord.max' => '密码不能多于25位',
        ]);
    }

    // 注册参数校验
    public static function register(Request $request) {
        return Validator::make($request->all(), [
            'userName' => 'required|min:6|max:25|unique:users',
            'passWord' => 'required|min:6|max:25',
        ], [
            'userName.required' => '用户名不能为空',
            'userName.min' => '用户名不能少于6位',
            'userName.max' => '用户名不能多于25位',
            'userName.unique' => '用户名已存在',
            'passWord.required' => '密码不能为空',
            'passWord.min' => '密码不能少于6位',
            'passWord.max' => '密码不能多于25位',
        ]);
    }

    // 添加文章参数校验
    public static function post(Request $request) {
        return Validator::make($request->all(), [
            'title' => 'required|min:2|max:25',
            'content' => 'required|min:2',
            'cid' => 'required|exists:cates'
        ], [
            'title.required' => '标题不能为空',
            'title.min' => '标题不能少于2位',
            'title.max' => '标题不能多于25位',
            'content.required' => '内容不能为空',
            'content.min' => '内容不能少于2位',
            'cid.required' => '缺少参数cid',
            'cid.exists' => '参数cid无效',
        ]);
    }

    // 添加文章类型校验
    public static function cate(Request $request) {
        return Validator::make($request->all(), [
            'name' => 'required|min:2|max:8|unique:cates',
        ], [
            'name.required' => '名称不能为空',
            'name.min' => '名称不能少于2位',
            'name.max' => '名称不能多于8位',
            'name.unique' => '名称已存在',
        ]);
    }

    // 添加评论校验
    public static function comment(Request $request) {
        return Validator::make($request->all(), [
            'uid' => 'required|exists:users',
            'pid' => 'required|exists:posts',
            'content' => 'required|max:800',
        ], [
            'uid.required' => '缺少参数uid',
            'uid.exists' => '用户uid无效',
            'pid.required' => '缺少参数pid',
            'pid.exists' => '文章pid无效',
            'content.required' => '评论不能为空',
            'content.max' => '评论不能多于800字符',
        ]);
    }

    // 回复评论校验
    public static function reply(Request $request) {
        return Validator::make($request->all(), [
            'uid' => 'required|exists:users',
            'mid' => 'required|exists:comments',
            'content' => 'required|max:800',
        ], [
            'uid.required' => '缺少参数uid',
            'uid.exists' => '用户uid无效',
            'mid.required' => '缺少参数mid',
            'mid.exists' => '评论mid无效',
            'content.required' => '回复不能为空',
            'content.max' => '回复不能多于800字符',
        ]);
    }
}
