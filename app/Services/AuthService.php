<?php

namespace App\Services;

use App\Exceptions\Auth\UnauthenticatedException;
use App\Exceptions\Auth\WronCredentialsException;
use App\Exceptions\User\UserNotFoundException;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class AuthService extends AbstractService
{
    /**
     * @param string $email
     * @param string $password
     * @return array
     * @throws WronCredentialsException
     */
    public function login(string $email, string $password): array
    {
        if (!$user = User::withoutTrashed()->where('email', $email)->first())
            throw new WronCredentialsException();

        if (!Hash::check($password, $user->password))
            throw new WronCredentialsException();

        if (!$token = Auth::guard('api')->login($user))
            throw new WronCredentialsException();

        return [
            'authorization' => $token,
            'type' => 'Bearer',
            'expires_in' => Carbon::now()->addMinutes(Config::get('jwt.ttl'))
        ];
    }

    /**
     * @return void
     * @throws UnauthenticatedException
     */
    public function logout(): void
    {
        if(!Auth::check())
            throw new UnauthenticatedException();

        Auth::guard('api')->logout();
    }
}
