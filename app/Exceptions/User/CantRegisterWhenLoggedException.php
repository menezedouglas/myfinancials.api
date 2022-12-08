<?php

namespace App\Exceptions\User;

use App\Exceptions\Exception;

class CantRegisterWhenLoggedException extends Exception
{
    protected $code = 400;

    protected $message = 'messages.exceptions.user.cant_register_when_logged';
}
