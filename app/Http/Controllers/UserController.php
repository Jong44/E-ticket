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

    public function updateProfile(Request $request)
    {
        $idUser = $user = Auth::id();
        $user = User::where('id', $idUser)->first();
        if($user){
            $user->first_name = $request->first_name ? $request->first_name : $user->first_name;
            $user->last_name = $request->last_name ? $request->last_name : $user->last_name;
            $user->username = $request->username ? $request->username : $user->username;
            $user->email = $request->email ? $request->email : $user->email;
            $user->no_hp = $request->no_hp ? $request->no_hp : $user->no_hp;
            $user->password = bcrypt($request->first_name) ? bcrypt($request->first_name) : $user->first_name;
            $user->save();
            return response()->json([
                'status' => 200,
                'message' => "Data user berhasil diubah", 
                'data' => $user
            ], 200);
            
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data dengan id ' . $id . ' tidak ditemukan'
            ], 404);
        }
    }

    public function deleteAccount()
    {
        $idUser = $user = Auth::id();
        $user = User::where('id', $idUser)->first();
        if($user){
            $user->delete();
            return response()->json([
                'status' => 200,
                'message' => "Account berhasil dihapus", 
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data dengan Id ' . $id . ' tidak ditemukan' 
            ], 404);
        }
    }
    
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return [
            'message' => 'Logged Out'
        ];

    }
}
