<?php

namespace App\Entity;

use Talleu\RedisOm\Om\Mapping as RedisOm;

// Entité représentant le panier de la session en cours 
#[RedisOm\Entity]
class Cart
{
    #[RedisOm\Id]
    #[RedisOm\Property]
    public ?string $id;

    #[RedisOm\Property]
    public array $products = []; // représente le tableau des produits sous forme d'objet CartProduct
}
