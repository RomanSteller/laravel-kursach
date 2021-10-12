<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request){
        $user = User::create([
            'login' => $request['login'],
            'name' => $request['name'],
            'password' => Hash::make($request['password']),
            'email' => $request['email'],
        ]);

        if($user){
            return response()->json([
                $user,
                "message" => "Пользователь успешно зарегестрирован"
            ])->setStatusCode(201);
        }
    }

    public function token(Request $request){
        $user = User::query()->where('login',$request->login)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json(['message' => 'Не верный логин или пароль'], 401);
        }

        $token = $user->createToken('token');
        return response()->json(['token' => $token->plainTextToken,$user]);

    }


}
