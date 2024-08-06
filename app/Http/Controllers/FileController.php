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
        //$userId = User::where('token', $request->bearerToken())->first();

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
            'author_id' => 2
        ]);

        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'Success',
            'name' => $filename,
            'url' => url()->current() . '/' . $file_id,
            'file_id' => $file_id
        ]);
    }

    public function update(Request $request, $file_id)
    {
        $fileId = File::where('file_id', $file_id)->first();
        /*$user = User::where('token', $request->bearerToken())->first();
        $userId = File::where('author_id', $user->id)->first();*/

        if (!$fileId) {
            return response()->json(     
                [   
                'message' => 'Not found',
                'code' => 404
                ]
            );
        }

      /*  if (!$userId) {
            return response()->json([
                'message' => 'Forbidden for you'
            ], 403);
        } */

        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
            'success' => false,
            'code' => 422,
            'message' => $validator->errors()
            ]);                
        }

        $fileId->update([
            'file_name' => $request->name,
        ]);

        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'Renamed',
        ]); 
    }
    

    public function destroy(Request $request, $file_id)
    {
        $fileId = File::where('file_id', $file_id)->first();
        /* 
        $user = User::where('token', $request->bearerToken())->first();
        $userId = File::where('author_id', $user->id)->first();*/
        
        if (!$fileId) {
            return response()->json(     
                [   
                'message' => 'Not found',
                'code' => 404
                ]
            );
        }

        /*
        if (!$userId) {
            return response()->json([
                'message' => 'Forbidden for you'
            ], 403);
        }*/

        $fileId->delete();
            
        return response()->json(
            [
                'success' => true,
                'code' => 200,
                'message' => 'File deleted'
            ]
        );
    }

    public function download(Request $request, $file_id)
    {
        $fileId = File::where('file_id', $file_id)->first();
       /* 
        $user = User::where('token', $request->bearerToken())->first();
        $userId = File::where('author_id', $user->id)->first();*/
        
        if (!$fileId) {
            return response()->json(     
                [   
                'message' => 'Not found',
                'code' => 404
                ]
            );
        }
        /*

        if (!$userId) {
            return response()->json([
                'message' => 'Forbidden for you'
            ], 403);
        }

        $path = url("/storage/{$fileId->file_name}");

        return response()->download($path); */
    }
}