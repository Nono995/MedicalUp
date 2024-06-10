<?php
namespace App\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;

abstract class AbstractController {

//    public function __construct(protected ?ContainerInterface $container)
//    {
//
//    }


    function render(RequestInterface $request, ResponseInterface $response, string $path, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, $path,$args );
    }
}