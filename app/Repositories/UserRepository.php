<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRepository
{
    public function all()
    {
        return User::all();
    }

    public function getOne($id)
    {
        return User::findOrFail($id);
    }

    public function create($data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return User::create($data);
    }

    public function update(User $user, array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        $user->update($data);
        return $user;
    }

    public function delete(User $user)
    {
        return $user->delete();
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public function createPasswordResetToken(User $user)
    {
        $token = Str::random(60);
        $user->password_reset_token = $token;
        $user->password_reset_token_created_at = now();
        $user->save();

        return $token;
    }

    public function resetPassword(User $user, $password)
    {
        $user->password = hash::make($password);
        $user->password_reset_token = null;
        $user->password_reset_token_created_at = null;
        $user->save();
    }

    public function findByPasswordResetToken($token)
    {
        return User::where('password_reset_token', $token)
            ->where('password_reset_token_created_at', '>=', now()->subHours(1))
            ->first();
    }
}
