<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;

class UploadController extends Controller
{

    public function uploadImage(Request $request) {

        $info = $request->all();

        $validator = Validator::make($info, [
            'file' => 'required|file|max:32768',      // max 32MB = 32768KB,
        ]);

        if ($validator->fails()) {
            $message = "validation failed";
            $failedRules = $validator->failed();

            if(isset($failedRules['file']['required'])) {
                $message = 'Tệp không được tìm thấy';
            }
            else if(isset($failedRules['file']['file'])) {
                $message = 'Không hỗ trợ định dạng tệp';
            }
            else if(isset($failedRules['file']['max'])) {
                $message = 'Kích thước tệp quá lớn';
            }

            return response()->json([
                'message' => $message,
                'data' => [
                    $validator->errors()->all()
                ]
            ], 400);
        }

        $file_id=time();
        $fileUpload = $request->file;
        $fileName = $file_id. '-' . $fileUpload->getClientOriginalName();
        $fileUpload->storeAs('public/images/checkin', $fileName);
        $path = "storage/images/checkin/" . $fileName;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data['url']=url($path);
        $data['file_id']= $file_id;
        $data['name']= $fileName;
        $data['type']= $type;
        return response()->json([
            'code'=>200,
            'message' => 'success',
            'result' => $data
        ]);
    }



}
