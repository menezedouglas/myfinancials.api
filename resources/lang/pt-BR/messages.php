<?php

return [
    'exceptions' => [
        'bank' => [
            'not_found' => 'Banco não encontrado.',
        ],
        'transaction' => [
            'not_found' => 'Transação não encontrada.',
        ],
        'payer' => [
            'not_found' => 'Pagador não encontrado.',
        ],
        'default' => 'Houve um problema em nosso servidor. Por favor, tente novamente mais tarde!',
        'user' => [
            'not_found' => 'Usuário não encontrado!',
            'cant_register_when_logged' => 'Você não pode se registrar enquanto estiver logado!',
        ],
        'auth' => [
            'wrong_credentials' => 'E-mail ou senha incorretos!',
            'unauthenticated' => 'Você não está autenticado!',
        ],
    ],
];
