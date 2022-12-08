<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService extends AbstractService
{
    public function profile(): User
    {
        return $this->getAuthenticatedUser();
    }

    public function register(string $name, string $email, string $password): User
    {
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->save();

        return $user;
    }

    public function update(?string $name = null, ?string $email = null, ?string $password = null): User
    {
        $user = $this->getAuthenticatedUser();

        if($name)
            $user->name = $name;

        if($email)
            $user->email = $email;

        if($password)
            $user->password = Hash::make($password);

        $user->save();

        return $user;
    }

    public function delete()
    {
        $user = $this->getAuthenticatedUser();
        $user->delete();

        $this->auth::logout();
    }
}
