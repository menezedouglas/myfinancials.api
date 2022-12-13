<?php

namespace App\Services;

use App\Exceptions\User\CantRegisterWhenLoggedException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService extends AbstractService
{
    /**
     * @return User
     */
    public function profile(): User
    {
        return $this->getAuthenticatedUser();
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @return User
     * @throws CantRegisterWhenLoggedException
     */
    public function register(string $name, string $email, string $password): User
    {
        if(Auth::check())
            throw new CantRegisterWhenLoggedException();

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->save();

        return $user;
    }

    /**
     * @param string|null $name
     * @param string|null $email
     * @param string|null $password
     * @return User
     */
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

    /**
     * @return void
     */
    public function delete()
    {
        $user = $this->getAuthenticatedUser();
        $user->delete();

        $this->auth::logout();
    }
}
