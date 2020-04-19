<?php

namespace App\Http\Controllers;

use App\Http\Config\Verify;
use App\Http\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // 添加用户帖子
    public function insert(Request $request) {

        $validate = Verify::post($request);
        if($validate->fails()) {
            return $this->verifyFails($validate);
        }

        $title = $request->input('title');
        $content = $request->input('content');
        $uid = $request->input('uid');
        $cid = $request->input('cid');

        $post = new Post;
        $post['title'] = $title;
        $post['content'] = $content;
        $post['uid'] = $uid;
        $post['cid'] = $cid;
        $post['top'] = 0;
        $result = $post->save();
        if (!$result) {
            return $this->error(100004);
        }
        return $this->success();
    }

    // 删除用户帖子
    public function delete(Request $request) {

        $pid = $request->input('pid');
        if (!$pid) {
            return $this->error(400004);
        }

        $result = Post::destroy($pid);
        if (!$result) {
            return $this->error(100004);
        }
        return $this->success();
    }

    // 查询用户帖子
    public function select(Request $request) {

        $uid = $request->input('uid');
        if (!$uid) {
            return $this->error(400005);
        }

        $posts = Post::where('uid', $uid)->get();
        return $this->success($posts);
    }

    // 修改用户帖子
    public function update(Request $request) {

        $pid = $request->input('pid');
        if (!$pid) {
            return $this->error(400004);
        }

        $validate = Verify::post($request);
        if($validate->fails()) {
            return $this->verifyFails($validate);
        }

        $title = $request->input('title');
        $content = $request->input('content');

        $post = Post::find($pid);
        $post['title'] = $title;
        $post['content'] = $content;
        $post['pid'] = $pid;
        $result = $post->save();
        if (!$result) {
            return $this->error(100004);
        }
        return $this->success();
    }


    // 添加置顶
    public function addTop(Request $request) {

        $pid = $request->input('pid');
        if (!$pid) {
            return $this->error(400004);
        }

        $post = Post::find($pid);
        $post['top'] = 1;
        $result = $post->save();
        if (!$result) {
            return $this->error(100004);
        }
        return $this->success();
    }

    // 取消置顶
    public function deleteTop(Request $request) {

        $pid = $request->input('pid');
        if (!$pid) {
            return $this->error(400004);
        }

        $post = Post::find($pid);
        $post['top'] = 0;
        $result = $post->save();
        if (!$result) {
            return $this->error(100004);
        }
        return $this->success();
    }

    // 查询置顶
    public function top(Request $request) {
        $posts = Post::where('top', 1)->get();
        return $this->success($posts);
    }


    // 查询列表
    public function list(Request $request) {

        $cid = $request->input('cid');
        if (!$cid) {
            $posts = Post::with('user')->paginate(10);
            return $this->success($posts);
        }

        $posts = Post::where('cid', $cid)->with('user')->get();
        return $this->success($posts);
    }
}
