<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
  public function index()
  {
      $users = User::all();

      if(count($users) > 0){
          return response([
              'message' => 'Daftar data User',
              'data' => $users
          ], 200);
      }

      return response([
          'message' => 'users empty',
          'data' => null
      ], 400);
  }

  public function show($id)
  {
    $user = User::find($id);

    if(!is_null($user)) {
        return response([
            'message' => 'Retrieve User Success',
            'data' => $user
        ], 200);
    }

    return response([
        'message' => 'User Not Found',
        'data' => null
    ], 400);
  }

  public function update(Request $request, $id)
  {
    $user = User::find($id);

    if(is_null($user)){
      return response()->json([
          'success' => false,
          'message' => 'User tidak ditemukan',
          'data' => ''
      ], 404);
    }

    $updateData = $request->all();

    $validate = Validator::make($updateData, [
      'name' => 'required|max:60',
      'email' => 'required|email:rfc,dns|unique:users',
      'password' => 'required',
      // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      'username' => 'required|min:6|max:12|regex:/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W)/'
    ]);

    if($validate->fails()){
      return response(['message' => $validate->errors()], 400);
    }

    $updateData['password'] = bcrypt($request->password);

    // $uploadFolder = 'users';
    // $image = $request->file('image');

    // $image_uploaded_path = $image->store($uploadFolder, 'public');

    // $updateData["image"] = basename($image_uploaded_path);

    $user->name = $updateData['name'];
    $user->password = $updateData['password'];
    $user->email = $updateData['email'];
    // $user->image = $updateData['image'];
    $user->username = $updateData['username'];
    $user->save();

    return response()->json([
      'success' => true,
      'message' => 'User berhasil diupdate',
      'data' => $user
    ], 200);
  }

}