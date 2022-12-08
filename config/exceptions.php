<?php

return [
    'reportable' => [
        \App\Exceptions\Auth\WronCredentialsException::class,
        \App\Exceptions\Auth\UnauthenticatedException::class,
        \App\Exceptions\Bank\BankNotFoundException::class,
        \App\Exceptions\Payer\PayerNotFoundException::class,
        \App\Exceptions\Transactions\TransactionNotFoundException::class,
        \App\Exceptions\User\UserNotFoundException::class,
        \App\Exceptions\DefaultException::class,
    ]
];
