<?php

use Slim\Http\Request;
use Slim\Http\Response;
use DevPledge\Application\Controller\Auth\AuthController;
use DevPledge\Application\Controller\OrganisationController;

// Routes

//$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
//    // Sample log message
//    $this->logger->info("Slim-Skeleton '/' route");
//
//    // Render index view
//    return $this->renderer->render($response, 'index.phtml', $args);
//});


$app->group('', function () use ($app) {

    $app->group('/organisation', function () use ($app) {

        $app->get('', OrganisationController::class . ':getOrganisation');

    });

})->add($jwtMiddleware);

$app->group('', function () use ($app, $jwtRefreshMiddleware) {

    $app->group('/auth', function () use ($app, $jwtRefreshMiddleware) {

        $app->post('/login', AuthController::class . ':login');

        $app
            ->post('/refresh', AuthController::class . ':refresh')
            ->add($jwtRefreshMiddleware);

    });

});
