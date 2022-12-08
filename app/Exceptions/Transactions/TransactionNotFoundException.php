<?php

namespace App\Exceptions\Transactions;

use App\Exceptions\Exception;

class TransactionNotFoundException extends Exception
{
    protected $code = 404;

    protected $message = 'messages.exceptions.transaction.not_found';
}
