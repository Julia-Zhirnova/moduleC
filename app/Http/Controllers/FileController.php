<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'files' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'message' => $validation->errors(),
            ]);
        }

        $file = $request->file('files');

        $filename = $file->getClientOriginalName();
        $file->storeAs('public', $filename);

        return response()->json([
            'message' => 'Файл успешно загружен!',
            'filename' => $filename
        ]);

    }
}
