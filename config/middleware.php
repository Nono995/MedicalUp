<?php


use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use SlimErrorRenderer\Middleware\ExceptionHandlingMiddleware;
use SlimErrorRenderer\Middleware\NonFatalErrorHandlingMiddleware;
use Twig\Error\LoaderError;

return function (\Slim\App $app) {

    // Handle exceptions and display error page
//    $app->add(ExceptionHandlingMiddleware::class);
//    // Promote warnings and notices to exceptions
//    $app->add(NonFatalErrorHandlingMiddleware::class);

    // Middleware templating twig
    try {
        $twig = Twig::create(__DIR__ . '/../templates', ['cache' => false]);
        $app->add(TwigMiddleware::create($app, $twig));
    } catch (LoaderError $e) {
        echo $e;
    }


};