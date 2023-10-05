<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function registerUser(Request $request)
    {
        $newuser = new User();
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'proses validasi gagal',
                'data' => $validator->errors(),
            ], 401);
        }

        $newuser->name = $request->name;
        $newuser->email = $request->email;
        $newuser->password = Hash::make($request->password);
        $newuser->save();

        return response()->json([
            'status' => true,
            'message' => 'user berhasil ditambahkan',
            'data' => $newuser,
        ], 200);
    }

    public function loginUser(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'proses login gagal',
                'data' => $validator->errors(),
            ], 401);
        }

        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'status' => false,
                'message' => 'email atau password tidak sesuai',
            ], 401);
        }

        $tokenUser = User::where('email', $request->email)->first();
        return response()->json([
            'status' => true,
            'message' => 'proses login berhasil',
            'token' => $tokenUser->createToken('api-product')->plainTextToken
        ], 200);
    }
}
