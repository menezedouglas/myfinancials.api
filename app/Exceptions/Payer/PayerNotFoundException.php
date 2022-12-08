<?php

namespace App\Exceptions\Payer;

use App\Exceptions\Exception;

class PayerNotFoundException extends Exception
{
    protected $code = 404;

    protected $message = 'messages.exceptions.payer.not_found';
}
