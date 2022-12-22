<?php

namespace App\Exceptions\User;

use App\Exceptions\Exception;
class NeedAcceptPrivacyPolicyException extends Exception
{
    protected $code = 403;

    protected $message = 'messages.exceptions.user.needs_accept_privacy_policy';
}
