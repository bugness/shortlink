<?php

use App\Entity\LinkRepository;
use App\Service\TokenGenerator;
use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\TwigServiceProvider;

$app = new Application();

$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());

$app['db'] = function ($app) {
    $db = $app['settings.db'];
    return new \PDO(
        sprintf('mysql:host=%s;port=3306;dbname=%s', $db['host'], $db['name']),
        $db['user'],
        $db['pass'],
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
};
$app['token_generator'] = function () {
    return new TokenGenerator();
};
$app['link_repository'] = function ($app) {
    return new LinkRepository($app['db']);
};

$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...

    return $twig;
});

return $app;
