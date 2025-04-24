<?php

namespace App\Service;

use App\Entity\Cart;
use App\Entity\CartProduct;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Talleu\RedisOm\Om\RedisObjectManagerInterface;

class CartService
{
    public function __construct(
        private SessionService $sessionService,
        private RedisObjectManagerInterface $redisObjectManager
    ) {}


    // Action pour ajouter un produit au panier
    public function addProductToCart(string $productId)
    {
        // Récuperer le panier en cours présent dans la session
        $cart = $this->getCart();

        // Ajouter au panier le produit avec une quantité égale à 1
        $cartProduct = new CartProduct($productId, 1);

        // Si le produit est déjà présent dans le panier, incrémenter sa quantité
        if (isset($cart->products[$productId])) {
            $cart->products[$productId]->quantity++;
        } else {
            $cart->products[$productId] = $cartProduct;
        }

        // Enregistrer et envoyer le panier à Redis
        $this->redisObjectManager->persist($cart);
        $this->redisObjectManager->flush();

        return $cart;
    }

    // Action pour obtenir le panier en cours
    public function getCart(): Cart
    {
        // Récupérer l'identifiant du panier en cours
        $cartId = $this->sessionService->getCartId();

        // Rechercher le panier à l'aide de son identifiant sur Redis
        $cart = $this->redisObjectManager->find(Cart::class, $cartId);

        // Si l'utilisateur n'a pas de panier, en créer un nouveau
        if (!$cart) {
            // Créer un nouvel objet panier mappable sur Redis
            $cart = new Cart;
            $cart->id = $cartId; // Assigner la valeur de l'identifiant du panier présent dans la session à l'objet de panier Redis
            $this->redisObjectManager->persist($cart); // envoyer le panier à Redis
        }
        return $cart;
    }
}
