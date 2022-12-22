<?php

namespace App\Services;

use App\Exceptions\User\CantRegisterWhenLoggedException;
use App\Exceptions\User\NeedAcceptPrivacyPolicyException;
use App\Exceptions\User\NeedAcceptTermsOfServiceException;
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
     * @param bool $privacyPolicy
     * @param bool $serviceTerms
     * @return User
     * @throws CantRegisterWhenLoggedException
     * @throws NeedAcceptPrivacyPolicyException
     * @throws NeedAcceptTermsOfServiceException
     */
    public function register(string $name, string $email, string $password, bool $privacyPolicy, bool $serviceTerms): User
    {
        if(Auth::check())
            throw new CantRegisterWhenLoggedException();

        if(!$privacyPolicy)
            throw new NeedAcceptPrivacyPolicyException();

        if(!$serviceTerms)
            throw new NeedAcceptTermsOfServiceException();

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
