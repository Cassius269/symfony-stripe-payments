<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Service\StripeService;
use App\Service\SessionService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class OrderController extends AbstractController
{
    // Injection de dépendance(s)
    public function __construct(
        private readonly SessionService $sessionService,
        private readonly StripeService $stripeService
    ) {}


    #[Route(
        path: '/products/{id}/buy',
        name: 'buy_product'
    )]
    public function buyProduct(string $id): Response
    {
        $cartId = $this->sessionService->getCartId();
        $products = $this->stripeService->getActiveProducts();

        $product = $this->stripeService->findOneProduct('prod_S8AxS93UT3TBCH');
        dd($product);
        return $this->render('home/index.html.twig', [
            'cartId' => $cartId,
            'products' => $products
        ]);
    }
}
