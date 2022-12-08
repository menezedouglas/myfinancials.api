<?php

namespace App\Exceptions\Auth;

use App\Exceptions\Exception;

class WronCredentialsException extends Exception
{
    protected $code = 403;

    protected $message = 'messages.exceptions.auth.wrong_credentials';
}
