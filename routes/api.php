<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// 登录
Route::any('user/login', 'AuthController@login');
// 注册
Route::any('user/register', 'AuthController@register');
// 重置密码
Route::any('user/reset', 'AuthController@reset');

// 添加分类
Route::any('cate/insert', 'CateController@insert');
// 删除分类
Route::any('cate/delete', 'CateController@delete');
// 查询分类
Route::any('cate/select', 'CateController@select');

// 查询文章列表
Route::any('post/list', 'PostController@list');

// 查询置顶
Route::any('post/top', 'PostController@top');
// 添加置顶
Route::any('post/addTop', 'PostController@addTop');
// 取消置顶
Route::any('post/deleteTop', 'PostController@deleteTop');

// 查询用户列表
Route::any('user/list', 'UserController@list');

// 查询评论列表
Route::any('comment/list', 'CommentController@list');
// 删除评论
Route::any('comment/delete', 'CommentController@delete');

// 查看回复
Route::any('comment/replies', 'CommentController@replies');

// 上传图片
Route::any('system/upload', 'SystemController@uploadImage');

//将一组路由限制为只允许登录用户访问
Route::group(['middleware'=>'auth:api'], function() {

    // 用户信息
    Route::any('user/info', 'UserController@info');

    // 发帖
    Route::any('post/insert', 'PostController@insert');
    // 删帖
    Route::any('post/delete', 'PostController@delete');
    // 修改
    Route::any('post/update', 'PostController@update');
    // 查询
    Route::any('post/select', 'PostController@select');

    // 评论
    Route::any('comment/insert', 'CommentController@insert');
    // 回复
    Route::any('comment/reply', 'CommentController@reply');
});
