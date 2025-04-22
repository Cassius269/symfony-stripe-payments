<?php

namespace App\Service;

use Stripe\Price;
use Stripe\Product;
use Stripe\StripeClient;
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

    // Action pour récupérer les produits actifs avec leur prix
    /**
     * @return Product[]
     * @throws ApiErrorException
     */
    public function getActiveProductsWithPrices(): array
    {
        // Récuperer les produits
        $activeProducts = self::getActiveProducts();

        // Associer chaque objet produit actif avec son objet prix
        $productsWithPrices = [];

        foreach ($activeProducts as $activeProduct) {
            $price = $this->client->prices->retrieve($activeProduct->default_price);

            $productsWithPrices[] = [
                'product' => $activeProduct,
                'price' => $price
            ];
        }

        return $productsWithPrices;
    }

    // Action pour récuperérer un seul produit depuis Stripe à l'aide de l'ID du produit
    public function findOneProduct(string $productId): Product
    {
        return $this->client->products->retrieve($productId);
    }

    // Récuperer le dernier prix actif d'un produit
    public function getLastActivePrice(Product $product): ?Price
    {
        return $this->client->prices->all([
            'product' => $product->id,
            'active' => true,
            'limit' => 1
        ])
            ->data[0] ?? null;
    }

    // Réaliser le paiement d'un produit à l'aide d'un lien de paiement Stripe
    public function getProductByUrl(Product $product, int $quantity = 1): string
    {
        // Récupération du prix
        $price = $this->getLastActivePrice($product);

        // Retourner l'URL de la session de paiement Stripe
        return $this->client->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $product->name,
                            'images' => $product->images
                        ],
                        'unit_amount' => $price->unit_amount
                    ],
                    'quantity' => $quantity,
                ]
            ],
            'mode' => 'payment',
            'success_url' => 'https://127.0.1:8000', // lien en cas de succès de paiement
            'cancel_url' => 'https://127.0.1:8000' // lien de redirection en cas d'échec de paiement
        ])
            ->url;
    }
}
