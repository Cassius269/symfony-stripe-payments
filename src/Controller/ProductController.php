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

        // dd($productsWithPrices);
        // $productsWithPrices = [];

        // foreach ($products as $product) {
        //     $price = new StripeClient('sk_test_51RDVGy2MIFYFfgML0cr6VYFYa5dchQS1kYmSRVBmrWTNvBykk0gmgX16JaOm6giwKjYOvNgirvYsAfRBp0SzF7Wi00AdasIqi3')->prices->retrieve($product->default_price);
        //     $productsWithPrices[] = [
        //         'product' => $product,
        //         'price' => $price
        //     ];
        // }

        // dd($productsWithPrices);
        // dd($products);
        return $this->render('product/index.html.twig', [
            'products' => $productsWithPrices
        ]);
    }
}
