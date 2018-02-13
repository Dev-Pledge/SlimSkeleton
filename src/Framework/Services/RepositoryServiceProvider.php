<?php

namespace DevPledge\Framework\Services;


use Psr\Container\ContainerInterface;
use TomWright\Database\ExtendedPDO\ExtendedPDO;
use DevPledge\Application\Repository\Organisation\OrganisationMySQLRepository;
use DevPledge\Application\Repository\Organisation\OrganisationRepository;

class RepositoryServiceProvider
{

    public function provide(ContainerInterface $c)
    {
        $c[OrganisationRepository::class] = function ($c) {
            return new OrganisationMySQLRepository($c->get(ExtendedPDO::class));
        };
    }

}