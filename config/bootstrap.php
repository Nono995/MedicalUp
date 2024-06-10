<?php

use DI\Container;
use DI\ContainerBuilder;
use DI\DependencyException;
use DI\NotFoundException;
use Psr\Container\ContainerInterface;
use Slim\App;

require __DIR__ . '/../vendor/autoload.php';

// Instantiate DI ContainerBuilder
$containerBuilder = new ContainerBuilder();
// Add container definitions and build DI container
try {
    $container = $containerBuilder->addDefinitions(__DIR__ . '/container.php')->build();
} catch (Exception $e) {
}

try {
    /** @var ContainerInterface $container */
    $container->get('db');
} catch (DependencyException $e) {
} catch (NotFoundException $e) {
}

// Create app instance
/** @var Container $container */
try {
    return $container->get(App::class);
} catch (DependencyException $e) {
} catch (NotFoundException $e) {
}

