<?php

namespace App\Controller;

use App\Service\SessionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    // Injection de dépendance(s)
    public function __construct(
        private readonly SessionService $sessionService
    ) {}

    #[Route(
        path: '/',
        name: 'home'
    )]
    public function index(): Response
    {
        $cartId = $this->sessionService->getCartId();
        dump($cartId);

        return $this->render('home/index.html.twig', [
            'cartId' => $cartId
        ]);
    }
}
