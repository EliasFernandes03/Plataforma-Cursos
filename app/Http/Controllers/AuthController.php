<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Firebase\JWT\JWT;
use Carbon\Carbon;

class AuthController extends Controller
{
    protected $loginRepository;
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials)) {
            $user = Auth::user();
            $token = $this->generateJwtToken($user);
            return response()->json([
                'message' => 'Login Successful',
                'token' => $token,
                'role' => $user->role,
                'name' => $user->name
            ])->cookie('jwt_token', $token, 120, '/', null, true, true);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    protected function generateJwtToken($user)
    {
        $secretKey = config('app.secret');

        $payload = [
            'iss' => "laravel_app",
            'sub' => $user->id,
            'iat' => Carbon::now()->timestamp,
            'exp' => Carbon::now()->addHours(2)->timestamp,
        ];

        return JWT::encode($payload, $secretKey, 'HS256');
    }
}
