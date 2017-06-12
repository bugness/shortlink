<?php

$app['twig.path'] = [__DIR__ . '/../templates'];
$app['twig.options'] = ['cache' => __DIR__ . '/../var/cache/twig'];

$app['settings.db'] = [
    'host' => '192.168.1.79',
    'name' => 'shortlink',
    'user' => 'root',
    'pass' => 'toor',
];

$app['settings.limit_of_attempts'] = 10;
