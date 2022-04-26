<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function register(Request $request)
    {
        $validatedData = $this->validate($request, [
            'name' => 'required|string|min:2|max:125',
            'surname' => 'required|string|min:2max:125',
            'patronymic' => 'required|string|min:2max:125',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|max:125'
        ]);
        $user = User::create($validatedData);
        $token = auth()->login($user);
        return response()->json(['data' => ['access_token' => $token, 'user' => $user,], 'message' => 'Registered!'], 201);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (!$token = auth()->setTTL(3600)->attempt($credentials)) {
            return response()->json(['status' => 404, 'message' => 'Неправильный логин или пароль.'], 404);
        }
        return response()->json(['data' => ['access_token' => $token, 'user' => auth()->user()], 'message' => 'Log In!'], 201);

    }

    public function user()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return response()->json(['access_token' => auth()->refresh()]);
    }
}
