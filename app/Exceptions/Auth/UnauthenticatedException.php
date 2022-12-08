<?php

namespace App\Exceptions\Auth;

use App\Exceptions\Exception;

class UnauthenticatedException extends Exception
{
    protected $code = 401;

    protected $message = 'messages.exceptions.auth.unauthenticated';
}
