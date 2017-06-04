<?php

use App\Service\TokenGenerator;
use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\TwigServiceProvider;

$app = new Application();

$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app->register(new DoctrineServiceProvider(), [
    'db.options' => [
        'driver'   => 'pdo_mysql',
        'charset'  => 'utf8mb4',
        'host'     => '192.168.1.79',
        'dbname'   => 'shortlink',
        'user'     => 'root',
        'password' => 'toor',
    ],
]);

$app['token_generator'] = function () {
    return new TokenGenerator();
};

$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...

    return $twig;
});

return $app;
