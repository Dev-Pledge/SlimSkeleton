<?php

namespace DevPledge\Application\Services;


use Psr\Container\ContainerInterface;
use DevPledge\Application\Controller\Auth\AuthController;
use DevPledge\Application\Controller\OrganisationController;
use DevPledge\Application\Repository\Organisation\OrganisationRepository;
use DevPledge\Application\Security\JWT\JWT;

class ControllerServiceProvider
{

    public function provide(ContainerInterface $c)
    {
        $c[AuthController::class] = function ($c) {
            return new AuthController($c->get(JWT::class));
        };

        $c[OrganisationController::class] = function ($c) {
            return new OrganisationController($c->get(OrganisationRepository::class));
        };
    }

}