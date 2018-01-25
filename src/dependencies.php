<?php
// DIC configuration

use DevPledge\Application\Services\ServiceProvider;

$container = $app->getContainer();

$provider = new ServiceProvider();
$provider->provide($container);
