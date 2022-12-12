<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use function PHPUnit\Framework\returnSelf;

class AuthController extends Controller
{
    public function register(Request $request) {
        $registrationData = $request->all();
        
        $validate = Validator::make($registrationData, [
            'name' => 'required|max:60',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'username' => 'required|min:6|max:12|regex:/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W)/'
        ]);

        if($validate->fails()) {
            return response(['message' => $validate->errors()], 400);
        }

        $registrationData['password'] = bcrypt($request->password);

        $uploadFolder = 'users';
        $image = $request->file('image');

        $image_uploaded_path = $image->store($uploadFolder, 'public');

        $registrationData["image"] = basename($image_uploaded_path);
        
        $user = User::create($registrationData);
        return response([
            'message' => 'Register Success',
            'user' => $user
        ], 201);
    }

    public function login(Request $request) {
        $loginData = $request->all();

        $validate = Validator::make($loginData, [
            'email' => 'required|email:rfc,dns',
            'password' => 'required'
        ]);

        if($validate -> fails()) 
            return response(['message' => $validate->errors()], 400);

        if(!Auth::attempt($loginData))
            return response(['message'=>'Invalid Credentials'], 401); // error gagal login
        

        $user = Auth::user();
        $token = $user->createToken('Authentication Token')->accessToken; // generate token

        return response([
            'message' => 'Authenticated',
            'user' => $user,
            'token_type' => 'Bearer',
            'access_token' => $token
        ]); // return data user dan token dalam bentuk json
    }

    public function logoutApi(Request $request)
    { 
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}