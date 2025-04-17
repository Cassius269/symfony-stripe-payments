<?php

namespace App\Service;

use Stripe\Product;
use Stripe\StripeClient;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class StripeService
{
    private StripeClient $client;

    // Injection de dépendance(s)
    public function __construct(
        private ParameterBagInterface $parameter // injection de service des paramètres de l'appplication
    ) {
        $apiKey = $this->parameter->get('STRIPE_API_KEY'); // récuperer la clé privée de Stripe

        $this->client = new StripeClient($apiKey); // attribuer une valeur à la propriété $client
    }

    // Action pour récuperer les produits actifs depuis Stripe
    /**
     * @return Product[]
     * @throws ApiErrorException
     */
    public function getActiveProducts(): array
    {
        return $this->client
            ->products->all(['active' => true])
            ->data;
    }


    // Action pour récuperérer un seul produit depuis Stripe
    public function findOneProduct(string $productId): Product
    {
        return $this->client->products->retrieve($productId);
    }
}
