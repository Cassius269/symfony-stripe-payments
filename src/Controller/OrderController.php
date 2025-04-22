<?php

namespace App\Controller;

use App\Service\StripeService;
use App\Service\SessionService;
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
        // Rechercher le produit à l'aide de son Id Stripe
        $product = $this->stripeService->findOneProduct($id);

        // Générer le lien de paiement du produit
        return $this->redirect($this->stripeService->getProductByUrl($product));
    }
}
