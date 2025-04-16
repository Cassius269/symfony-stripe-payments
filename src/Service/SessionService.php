<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;

// Service personnalisée de gestion de panier utilisateur en session
class SessionService
{
    public const CART_ID_KEY = 'cardID';

    // Injection de dépendance(s)
    public function __construct(
        private RequestStack $requestStack
    ) {}

    // Enregistrer l'identifiant d'un panier de produits dans une session
    public function setCartId(string $cardId): void
    {
        // Récuperer la session 
        $session = $this->requestStack->getSession();

        // Enregistrer l'identifiant d'un panier dans la session
        $session->set(self::CART_ID_KEY, $cardId);
    }

    // Obtenir l'identifiant d'un panier de produits depuis une session
    public function getCartId(): ?string
    {
        // Récuperer la session 
        $session = $this->requestStack->getSession();

        // Récuperer la clé du panier actuel
        $cardId = $session->get(self::CART_ID_KEY);

        // Si aucune clé de panier existe, en générer une
        if ($cardId === null) {
            $cardId = uniqid('cart_');
            $this->setCartId($cardId);
        }

        return $cardId;
    }
}
