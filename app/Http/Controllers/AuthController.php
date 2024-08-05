<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
            'first_name' => 'required',
            'last_name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
            'success' => false,
            'code' => 422,
            'message' => $validator->errors()
            ]);                
        }

        $user = User::create([
            'email' => $request -> email,
            'password' => $request -> password,
            'first_name' => $request -> first_name,
            'last_name' => $request -> last_name,
            'token' => Str::random(35)
        ]);
    }    
}