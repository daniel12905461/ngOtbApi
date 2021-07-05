<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function register(Request $request){
        $user = new User([
            'email' => $request->email,
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ]);

        $user->save();

        $token = $user->createToken('authToken')->accessToken;

        return response()->json([
            'ok' =>true,
            'user'=> $user,
            'token'=>$token
        ]);
    }

    public function login(Request $request){

        $data = $request->only('email', 'password');

        if (! Auth::attempt($data)) {
            return response()->json([
                'ok' =>false,
                'message'=> 'error de credenciales',
            ]);
        }

        $token = Auth::user()->createToken('authToken')->accessToken;

        return response()->json([
            'ok' =>true,
            'user'=> Auth::user(),
            'token'=>$token
        ]);
    }

    public function me(){
        return response()->json([
            'ok' =>true,
            'user'=> Auth::user()
        ]);
    }
}
