<?php

namespace App\Exceptions;

class DefaultException extends Exception
{
    protected $code = 500;

    protected $message = 'messages.exceptions.default';
}
