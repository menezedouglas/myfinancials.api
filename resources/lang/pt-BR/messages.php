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
            'needs_accept_privacy_policy' => 'Você precisa aceitar a política de privacidade para continuar!',
            'needs_accept_terms_of_service' => 'Você precisa aceitar os termos de serviço para continuar!'
        ],
        'auth' => [
            'wrong_credentials' => 'E-mail ou senha incorretos!',
            'unauthenticated' => 'Você não está autenticado!',
        ],
    ],
];
