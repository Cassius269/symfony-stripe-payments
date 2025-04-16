<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Stripe\StripeClient;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class StripePaymentService
{
    // Injection de dépendance(s)
    public function __construct(
        private ParameterBagInterface $parameterBag, // dépendance de gestion des paramètres de configurations
        private LoggerInterface $logger
    ) {}

    public function createPaymentIntent(int $amount): string
    {
        try {

            $apiKey = $this->parameterBag->get('API_PRIVATE_KEY_STRIPE');
            $stripe = new StripeClient($apiKey);

            $paymentIntent = $stripe->paymentIntents->create([
                'amount' => $amount * 100, // montant en euro multiplié par 100 pour obtenir le montant en centimes
                'currency' => 'eur',
                'description' => 'Description du produit ou service', // à personnaliser
                'automatic_payment_methods' => [
                    'enabled' => true,
                ]
            ]);


            return $paymentIntent->client_secret;
        } catch (\Stripe\Exception\CardException $e) {
            // Erreur liée à la carte
            $error_message = 'Erreur de carte : ' . $e->getMessage();
            // Log l'erreur et renvoie un message approprié
            throw new \Exception($error_message);
        } catch (\Stripe\Exception\RateLimitException $e) {
            // Trop de requêtes trop rapidement
            $error_message = 'Trop de requêtes : ' . $e->getMessage();
            throw new \Exception($error_message);
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Paramètres invalides
            $error_message = 'Requête invalide : ' . $e->getMessage();
            throw new \Exception($error_message);
        } catch (\Stripe\Exception\AuthenticationException $e) {
            // Erreur d'authentification
            $error_message = 'Erreur d\'authentification : ' . $e->getMessage();
            throw new \Exception($error_message);
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            // Problème de connexion réseau
            $error_message = 'Erreur de connexion : ' . $e->getMessage();
            throw new \Exception($error_message);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Erreur générale de l'API Stripe
            $error_message = 'Erreur API : ' . $e->getMessage();
            throw new \Exception($error_message);
        } catch (\Exception $e) {
            // Autre erreur
            $error_message = 'Erreur inattendue : ' . $e->getMessage();
            throw new \Exception($error_message);
        }
    }

    // // Méthode pour recupérer les cartes d'un utilisateur
    // public function getCards(): \Stripe\Collection
    // {
    //     $apiKey = $this->parameterBag->get('API_PRIVATE_KEY_STRIPE');
    //     $stripe = new StripeClient($apiKey);

    //     $cards = $stripe->paymentMethods->all([
    //         'customer' => $this->stripe_id,
    //         'type' => 'card'
    //     ]);

    //     return $cards;
    // }
}
