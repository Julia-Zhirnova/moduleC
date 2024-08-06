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
            'message' => $validator->errors()
            ]);                
        }

        $file = $request->file('files');

        $filename = $file->getClientOriginalName();
        $file->storeAs('public', $filename);

        $file_id = Str::random(10);

        File::create([
            'file_name' => $filename,
            'file_id' => $file_id,
        ]);

        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'Success',
            'name' => $filename,
            'url' => url()->current() . '/' . $file_id
            'file_id' => $file_id
        ]);

    }
}
