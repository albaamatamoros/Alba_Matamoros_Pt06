<?php
    require_once __DIR__ . '/../../env.php';
    return [
        'callback' => URL_REDDIT_LOCALHOST,
        'providers' => [
            'Reddit' => [
                'enabled' => true,
                //LOCALHOST
                'keys' => [
                    'id' => ID_REDDIT_LOCALHOST,
                    'secret' => SECRET_REDDIT_LOCALHOST
                ],
                'scope' => 'identity'
            ],
        ],
    ];
?>