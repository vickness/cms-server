<?php

namespace App\Http\Controllers;

use App\Http\Config\Verify;
use App\Http\Models\Comment;
use App\Http\Models\Reply;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // 添加评论
    public function insert(Request $request) {

        $validate = Verify::comment($request);
        if ($validate->fails()) {
            return $this->verifyFails($validate);
        }

        $uid = $request->input('uid');
        $pid = $request->input('pid');
        $content = $request->input('content');

        $comment = new Comment;
        $comment['content'] = $content;
        $comment['pid'] = $pid;
        $comment['uid'] = $uid;
        $result = $comment->save();
        if (!$result) {
            return $this->error(100004);
        }
        return $this->success();
    }

    // 删除评论
    public function delete(Request $request) {

        $mid = $request->input('mid');
        if (!$mid) {
            return $this->error(400007);
        }

        $result = Comment::destroy($mid);
        if (!$result) {
            return $this->error(100004);
        }
        return $this->success();
    }

    // 查询评论
    public function list(Request $request) {

        $pid = $request->input('pid');
        if (!$pid) {
            return $this->error(400004);
        }

        $comments = Comment::where('pid', $pid)->with('user', 'replies')->get();
        return $this->success($comments);
    }

    // 回复评论
    public function reply(Request $request) {

        $validate = Verify::reply($request);
        if ($validate->fails()) {
            return $this->verifyFails($validate);
        }

        $uid = $request->input('uid');
        $mid = $request->input('mid');
        $content = $request->input('content');

        $model = new Reply;
        $model['content'] = $content;
        $model['mid'] = $mid;
        $model['uid'] = $uid;
        $result = $model->save();
        if (!$result) {
            return $this->error(100004);
        }
        return $this->success();
    }

    // 回复列表
    public function replies(Request $request) {

        $mid = $request->input('mid');
        if (!$mid) {
            return $this->error(400007);
        }

        $models = Reply::where('mid', $mid)->with('user')->get();
        return $this->success($models);
    }
}
