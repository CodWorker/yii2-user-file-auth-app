<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower',
        '@npm'   => '@vendor/npm',
    ],
    'language' =>'ru-RU',
    'timeZone' => 'Europe/Kiev',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        // перевод
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/translations',
                    //'sourceLanguage' => 'en-US',
                    'forceTranslation' => true,
                    'fileMap' => [
                        'app'       => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
    ],
];
