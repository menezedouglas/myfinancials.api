<?php

namespace App\Exceptions\User;

use App\Exceptions\Exception;

class UserNotFoundException extends Exception
{
    protected $code = 404;

    protected $message = 'messages.exceptions.user.not_found';
}
