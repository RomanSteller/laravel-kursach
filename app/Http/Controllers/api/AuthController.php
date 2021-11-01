<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $regUser = User::where('login', $request['login'])->get();

        if ($regUser) {
            return response()->json(['message' => 'Такой пользовател уже существует'])->setStatusCode(404);
        } else {
            User::create([
                'login' => $request['login'],
                'name' => $request['name'],
                'password' => Hash::make($request['password']),
                'email' => $request['email']]);

            return response()->json(["message" => "Пользователь успешно зарегестрирован"])->setStatusCode(201);
        }
    }


    public function token(Request $request)
    {
        $user = User::query()->where('login', $request->login)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Не верный логин или пароль'], 401);
        }

        $token = $user->createToken('token');
        return response()->json(['token' => $token->plainTextToken, $user]);

    }


}
