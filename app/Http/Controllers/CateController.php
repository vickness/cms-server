<?php

namespace App\Http\Controllers;

use App\Http\Config\Verify;
use App\Http\Models\Cate;
use Illuminate\Http\Request;

class CateController extends Controller
{
    // 添加分类
    public function insert(Request $request) {

        $validate = Verify::cate($request);
        if($validate->fails()) {
            return $this->verifyFails($validate);
        }

        $name = $request->input('name');

        $cate = new Cate;
        $cate['name'] = $name;
        $result = $cate->save();
        if (!$result) {
            return $this->error(100004);
        }
        return $this->success();
    }

    // 删除分类
    public function delete(Request $request) {

        $cid = $request->input('cid');
        if (!$cid) {
            return $this->error(400006);
        }

        $result = Cate::destroy($cid);
        if (!$result) {
            return $this->error(100004);
        }
        return $this->success();
    }

    // 查询分类
    public function select(Request $request) {
        $cate = Cate::all();
        return $this->success($cate);
    }
}
