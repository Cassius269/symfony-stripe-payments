<?php

namespace App\Controller;

use App\Service\StripeService;
use App\Service\SessionService;
use Stripe\StripeClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ProductController extends AbstractController
{
    // Injection de dépendance(s)
    public function __construct(
        private readonly SessionService $sessionService,
        private readonly StripeService $stripeService
    ) {}

    #[Route('/products', name: 'list_products')]
    public function index(): Response
    {
        $products = $this->stripeService->getActiveProducts();

        $productsWithPrices = $this->stripeService->getActiveProductsWithPrices();

        return $this->render('product/all_products.html.twig', [
            'products' => $productsWithPrices
        ]);
    }
}
