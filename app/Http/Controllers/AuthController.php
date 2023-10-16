<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function index(){
        if(!Auth::check()){
            return response()->json([
                'status' => 401,
                'error'=> 'Unauthorized',
                'data' => null
               ]);
        }
        $user = User::orderBy('created_at','desc')->get();
        return response()->json([
            'status' => 200,
            'message'=> 'user list',
            'data' => $user
           ]);
    }

    public function registerUser(Request $request){
        $validator = Validator::make($request->all(), [
            'f_name' => 'required',
            'l_name' => 'required',
            'username' => 'required',
            'DOB' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'profId' => 'required',
            'ID_no' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|max:13',
            'password' => 'required|min:6',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ]);
        }
        $user = User::create([
            'f_name' => $request->input('f_name'),
            'l_name' =>$request->input('l_name'),
            'DOB' => $request->input('DOB'),
            'username' => $request->input('username'),
            'address' => $request->input('address'),
            'email' => $request->input('email'),
            'gender' => $request->input('gender'),
            'profId' => $request->input('profId'),
            'phone' => $request->input('phone'),
            'ID_no' => $request->input('ID_no'),
            'password' => Hash::make($request->input('password'))
        ]);
        $userToken = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status'=> 200,
            'message' => ' user registered successfull',
            'token' => $userToken,
            'user' => $user,
        ]);
    }

  public function login(Request $request){
     $validator = Validator::make($request->all(),[
      'username'=> 'required',
      'password' => 'required|min:6'
     ]);

     if ($validator->fails()) {
        return response()->json([
            'status' => 400,
            'errors' => $validator->errors(),
        ]);
     }

     if(Auth::attempt(['username'=> $request->input('username'), 'password'=> $request->input('password')])){
        $user = Auth::user();
        $userToken = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 200,
            'message' => 'Login successful',
            'token' => $userToken,
            'user' => $user,
        ]);
    } else {
        return response()->json([
            'status' => 401,
            'message' => 'Unauthorized',
        ], 401);
    }
     }
    
}
