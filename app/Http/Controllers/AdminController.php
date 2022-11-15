<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Admin;


class AdminController extends Controller
{

    public function getAdmin()
    {
        $admin = Auth::user();
        return response()->json(['data' => $admin]);
    }

    public function getAllAdmin()
    {
        $admin = Admin::all();
        return $admin;
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

        if (Auth::guard('admin')->attempt(['email' => $input['email'], 'password' => $input['password']])){
            $user = Auth::guard('admin')->user();

            $token = $user->createToken('MyToken', ['admin'])->plainTextToken;

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

    

        $user = Admin::create([
            'first_name' => $fields['first_name'],
            'last_name' => $fields['last_name'],
            'username' => $fields['username'],
            'email'=> $fields['email'],
            'no_hp' => $fields['no_hp'],
            'alamat' => $fields['alamat'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('MyToken', ['admin'])->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function updateProfile(Request $request)
    {
        $idUser = $user = Auth::id();
        $user = Admin::where('id', $idUser)->first();
        if($user){
            $user->first_name = $request->first_name ? $request->first_name : $user->first_name;
            $user->last_name = $request->last_name ? $request->last_name : $user->last_name;
            $user->username = $request->username ? $request->username : $user->username;
            $user->email = $request->email ? $request->email : $user->email;
            $user->no_hp = $request->no_hp ? $request->no_hp : $user->no_hp;
            $user->alamat = $request->alamat ? $request->alamat : $user->alamat;
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
        $user = Admin::where('id', $idUser)->first();
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
