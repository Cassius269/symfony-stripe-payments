<?php

namespace App\Controller;

use App\Service\SessionService;
use App\Service\StripeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    // Injection de dépendance(s)
    public function __construct(
        private readonly SessionService $sessionService,
        private readonly StripeService $stripeService
    ) {}

    #[Route(
        path: '/',
        name: 'home'
    )]
    public function index(): Response
    {
        $cartId = $this->sessionService->getCartId();
        $products = $this->stripeService->getActiveProducts();

        return $this->render('home/index.html.twig', [
            'cartId' => $cartId,
            'products' => $products
        ]);
    }
}
