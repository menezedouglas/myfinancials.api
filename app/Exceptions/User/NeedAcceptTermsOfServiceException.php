<?php

namespace App\Exceptions\User;

use App\Exceptions\Exception;
class NeedAcceptTermsOfServiceException extends Exception
{
    protected $code = 403;

    protected $message = 'messages.exceptions.user.needs_accept_terms_of_service';
}
