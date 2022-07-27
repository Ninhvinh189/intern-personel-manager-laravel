<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use PhpParser\Node\Stmt\TryCatch;
use JWTAuth;

class AuthController extends Controller
{

    public function showRegisterForm()
    {
        return view('backend.auth.register');
    }

    public function register(RegisterRequest $request)
    {
        return User::create([
            'name' => $request->input('firstName').''.$request->input('lastName'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        try{
            $token = JWTAuth::attempt($credentials);
            if ($token)
            {
                return $this->respondWithToken($token);
            }
        }catch (UnauthorizedException $exception)
        {
          return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function logout()
    {
        auth()->logout();
        return response("Ok");
    }

    public function user()
    {
        return response()->json(auth()->user());
    }

    protected function respondWithToken($token): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

}
