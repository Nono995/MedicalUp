<?php


use App\Infrastructure\Utility\Settings;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use RedBeanPHP\R;
use SlimErrorRenderer\Middleware\ExceptionHandlingMiddleware;
use SlimErrorRenderer\Middleware\NonFatalErrorHandlingMiddleware;

return [
    'settings' => function(ContainerInterface $container) {
        return require __DIR__ . '/settings.php';
    },
    App::class => function(ContainerInterface $container) {
        $app = AppFactory::createFromContainer($container);

        (require __DIR__.'/middleware.php')($app);
        (require __DIR__.'/routes.php')($app);

        return $app;
    },
    'db' => function(ContainerInterface $container) {
        R::setup('mysql:host=localhost;dbname=medical-up', 'root', '');
        if (!R::testConnection()) {
            die('Impossible de se connecter à la base de données');
        }
        var_dump("reussi");
//        R::debug(true);
        return R::getDatabaseAdapter()->getDatabase();
    },
    Settings::class => function(ContainerInterface $container) {
        return new Settings($container-get('settings'));
    },
//    ExceptionHandlingMiddleware::class => function(ContainerInterface $container) {
//        $settings = $container-get('settings');
//        /** @var App $app */
//        $app = $container-get(App::class);
//
//        return new ExceptionHandlingMiddleware(
//            $app->getResponseFactory(),
//            $settings['error']['log_errors'] ? $container->get(LoggerInterface::class) : null,
//            $settings['error']['display_error_details'],
//            $settings['public']['main_contact_email'] ?? null
//        );
//    },
//    NonFatalErrorHandlingMiddleware::class => function(ContainerInterface $container) {
//        $settings = $container->get('settings');
//        return new NonFatalErrorHandlingMiddleware(
//            $settings['error']['display_error_details'],
//            $settings['error']['log_errors'] ? $container->get(LoggerInterface::class) : null,
//        );
//    },
];
