<?php


use Slim\App;

return function (App $app) {

    $app->get('/', \App\Controllers\HomeController::class.':home');

};