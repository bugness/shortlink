<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig', []);
})->bind('homepage');

$app->post('/generate', function (Request $request) use ($app) {
    $destination = $request->get('destination');

    if (filter_var($destination, FILTER_VALIDATE_URL) === false) {
        return $app->json([
            'error' => 'Incorrect link',
        ], Response::HTTP_BAD_REQUEST);
    }

    $repository = $app['link_repository'];

    $link = $repository->findOneBy('destination', $destination);

    if (!$link) {
        $attempt = 1;
        $limit   = $app['settings.limit_of_attempts'];
        do {
            $code = $app['token_generator']->getToken(6);
            $attempt++;
        } while ($attempt < $limit && $repository->findOneBy('code', $code));

        if ($attempt == $limit) {
            return $app->json([
                'error' => 'Sorry but we can\'t generate short link for your URL',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $link = $repository->create();
        $link->setDestination($destination);
        $link->setCode($code);

        $repository->persist($link);
    }

    return $app->json([
        'code' => $link->getCode(),
    ]);
})->bind('generator');

$app->get('/{code}', function ($code) use ($app) {
    $link = $app['link_repository']->findOneBy('code', $code);
    if (!$link) {
        throw new NotFoundHttpException('Link not found');
    }
    return $app->redirect($link->getDestination());
})->bind('goto');

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = [
        'errors/' . $code . '.html.twig',
        'errors/' . substr($code, 0, 2) . 'x.html.twig',
        'errors/' . substr($code, 0, 1) . 'xx.html.twig',
        'errors/default.html.twig',
    ];

    return new Response($app['twig']->resolveTemplate($templates)->render(['code' => $code]), $code);
});
