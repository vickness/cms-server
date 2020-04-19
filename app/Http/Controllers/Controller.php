<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

// 导入错误码
$error_code = require __DIR__.'/../Config/Code.php';
define("error_code", $error_code['code']);

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // 返回成功
    public function success($data = null, $message = null) {
        $result = [
            "status" => true,
            "msg"  => $message ? $message : '操作成功',
            "data" => $data,
        ];
        return response()->json($result);
    }

    // 返回失败
    public function error($code, $message = null) {
        $result = [
            "status" => false,
            "msg"  => $message ? $message : error_code[$code],
            "data" => $code
        ];
        return response()->json($result);
    }

    // 返回参数校验失败
    public function verifyFails($validate) {
        return $this->error(100003, $validate->errors()->first());
    }

    /**
     * 验证文件是否合法，并保存
     */
    public function store($file, $disk = 'public') {
        // 1.是否上传成功
        if (! $file->isValid()) {
            return false;
        }

        // 2.是否符合文件类型 getClientOriginalExtension 获得文件后缀名
        $fileExtension = $file->getClientOriginalExtension();
        if(! in_array($fileExtension, ['png', 'jpg', 'gif'])) {
            return false;
        }

        // 3.判断大小是否符合 2M
        $tmpFile = $file->getRealPath();
        if (filesize($tmpFile) >= 2048000) {
            return false;
        }

        // 4.是否是通过http请求表单提交的文件
        if (! is_uploaded_file($tmpFile)) {
            return false;
        }

        // 5.每天一个文件夹,分开存储, 生成一个随机文件名
        $fileName = date('Y_m_d').'/'.md5(time()) .mt_rand(0,9999).'.'. $fileExtension;

//        $filename = 'data/upload/'.time().mt_rand(999, 9999).'.'.$ext; //文件路径，存入数据库
//        Storage::disk('public')->put($filename, file_get_contents($path));

        // 文件保默认保存在 storage/app/public，可在 config/filesystems.php 配置
        if (Storage::disk($disk)->put($fileName, file_get_contents($tmpFile)) ){
            return Storage::url($fileName);
        }
    }
}
