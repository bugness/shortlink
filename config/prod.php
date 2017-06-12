<?php

$app['twig.path'] = [__DIR__ . '/../templates'];
$app['twig.options'] = ['cache' => __DIR__ . '/../var/cache/twig'];

$app['db'] = function () {
    return new PDO('mysql:host=192.168.1.79;port=3306;dbname=shortlink', 'root', 'toor', [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
};

$app['settings.limit_of_attempts'] = 10;
