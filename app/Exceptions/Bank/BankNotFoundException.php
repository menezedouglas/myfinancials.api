<?php

namespace App\Exceptions\Bank;

use App\Exceptions\Exception;

class BankNotFoundException extends Exception
{
    protected $code = 404;

    protected $message = 'messages.exceptions.bank.not_found';
}
