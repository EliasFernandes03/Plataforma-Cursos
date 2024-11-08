<?php

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::middleware(['web'])->group(function () {
    Route::get('auth/google', function () {
        return Socialite::driver('google')->redirect();
    })->name('auth.google');

    Route::get('auth/google/callback', function () {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'password' => bcrypt(Str::random(16))
            ]
        );

        Auth::login($user);

        return redirect('/dashboard');
    });
});
