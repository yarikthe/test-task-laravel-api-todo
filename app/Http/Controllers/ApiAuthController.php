<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class ApiAuthController extends ApiBaseController
{
    //
    public function register(Request $request){

        $validateUser = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);

        if($validateUser->fails()){
            return $this->errorResponse($validateUser->errors(), 'Error validate', 401);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);

        $response = [
            'user' =>  $user,
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ];

        return $this->successResponse($response,  'Register is Successfully!');
    }

    public function login(Request $request){

        $validateUser = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validateUser->fails()){
            return $this->errorResponse($validateUser->errors(), 'Error validate', 401);
        }

        if(!Auth::attempt($request->only(['email', 'password']))){
            return $this->errorResponse('Email or Password is not correctly!', 'Error auth', 401);
        }

        $user = User::where('email', $request->email)->first();

        $response = [
            'user' =>  $user,
            'token' => $user->createToken("API TOKEN")->plainTextToken,
            'tasks' => $user->tasks
        ];

        return $this->successResponse($response,  'Auth is Successfully!');
    }
}
