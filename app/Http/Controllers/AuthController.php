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

        return response()->json([
            'success' => true,
            'code' => 201,
            'message' => 'Success',
            'token' => $user->token
            ]);

    }
    
    public function login(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'            
        ]);

        if ($validator->fails()) {
            return response()->json([
            'success' => false,
            'code' => 422,
            'message' => $validator->errors()
            ]);                
        }

        $user = User::where('email', $request->email)->where('password', $request->password)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'code' => 401,
                'message' => 'Authorization failed'
            ]);
        }

        $token = $user->token = Str::random(35);
        $user->save();

        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'Success',
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $user = User::where('token', $request->bearerToken())->first();
        
        $user->update([
            'token' => NULL,
        ]);

        return response()->json([], 204);
        
    }    
    
}