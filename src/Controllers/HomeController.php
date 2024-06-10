<?php

namespace App\Controllers;

use App\Models\User;
use App\Repository\UserRepository;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use RedBeanPHP\R;

class HomeController extends AbstractController {

    public function __construct(private readonly UserRepository $userRepository)
    {

    }

    public function home(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
//        R::setup('mysql:host=localhost;dbname=medical-up', 'root', '');
        $user = new User();

        $user->setFirstname("Herve");
        $user->setLastname('Ngounou');

        $this->userRepository->save($user);

        return $this->render($request, $response,'pages/home/home.html.twig', [
            "name" => "bonjour le monde",
        ]);
    }

}