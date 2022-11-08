<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class UserController extends Controller
{
    public function getAdmin()
    {
        $user = Auth::user();
        return response()->json(['data' => $user]);
    }

    public function getAllUser()
    {
        $user = User::all();
        return $user;
    }

    public function login(Request $request)
    {
        $input = $request->all();

        $validate = \Validator::make($input,[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validate->fails()){
            return response()->json(['error' => $validate->errors()], 422);
        }

        if (Auth::guard('user')->attempt(['email' => $input['email'], 'password' => $input['password']])){
            $user = Auth::guard('user')->user();

            $token = $user->createToken('MyToken', ['user'])->plainTextToken;

            return response()->json(['token' => $token]);

        }
        else {
            return response([
                'message' => 'Unathorized'
            ], 401);
        }
    }

    public function register(Request $request)
    {
        $fields = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'username' => 'required|string|max:100',
            'no_hp' => 'required|string|max:100',
            'alamat' => 'required|string|max:100',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed|min:6'
        ]);

    

        $user = User::create([
            'first_name' => $fields['first_name'],
            'last_name' => $fields['last_name'],
            'username' => $fields['username'],
            'email'=> $fields['email'],
            'no_hp' => $fields['no_hp'],
            'alamat' => $fields['alamat'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('MyToken', ['user'])->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
    
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return [
            'message' => 'Logged Out'
        ];

    }
}
