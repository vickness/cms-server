<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SystemController extends Controller
{
    // 上传图片（单张/多张）
    public function uploadImage(Request $request)
    {
        $files = $request->file('file');
        if (! $files) {
            return $this->error(100005);
        }
        $fileNames = [];
        foreach ($files as $file) {
            $fileName = $this->store($file);
            if (!$fileName) {
                return $this->error(100005);
            }
            $fileNames[] = $fileName;
        }
        return $this->success($fileNames);
    }
}
