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
            return response()->json(['access_token' => $token, 'token_type' => 'Bearer'], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    protected function generateJwtToken($user)
    {
        $secretKey = config('app.secret');
        
        $payload = [
            'iss' => "laravel_app", // Emissor do token
            'sub' => $user->id, // Identificação do usuário
            'iat' => Carbon::now()->timestamp, // Timestamp de criação
            'exp' => Carbon::now()->addHours(2)->timestamp, // Expiração do token (2 horas)
        ];

        // Gera o token JWT com a chave secreta
        return JWT::encode($payload, $secretKey, 'HS256');
    }
}
