<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Service\CartService;
use App\Service\StripeService;
use App\Service\SessionService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Talleu\RedisOm\Om\RedisObjectManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Talleu\RedisOm\Client\PredisClient;

final class OrderController extends AbstractController
{
    // Injection de dépendance(s)
    public function __construct(
        private readonly SessionService $sessionService,
        private readonly StripeService $stripeService,
        private RedisObjectManagerInterface $redisObjectManager,
        private readonly CartService $cartService
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


    #[Route(
        path: '/products/{id}/add-to-cart',
        name: 'add_products_to_cart'
    )]
    public function addToCart(string $id): Response
    {
        // Ajouter le produit au panier
        $cart = $this->cartService->addProductToCart($id);

        return $this->redirectToRoute('home'); // rediriger à la page d'accueil à chaque ajout de produit dans le panier
    }


    // Action pour acheter tous les produits d'un panier
    #[Route(
        path: '/products/{id}/buy-cart',
        name: 'buy_cart'
    )]
    public function buyCart(): Response
    {
        // Récupérer le panier
        $cart = $this->cartService->getCart();

        // Renvoyer le lien de paiement Stripe au client en tant que réponse
        return $this->redirect($this->stripeService->getCartByUrl($cart));
    }
}
