<?php

namespace App\Entity;

use Talleu\RedisOm\om\Mapping as RedisOm;

// Un cartProduct est le produit élementaire se trouvant dans un panier en session représenté par son ID Stripe et sa quantité
#[RedisOm\Entity]
class CartProduct
{
    #[RedisOm\Id]
    #[RedisOm\Property]
    public ?string $id = null;

    #[RedisOm\Property]
    public ?int $quantity = null;

    public function __construct(?string $id = null, ?int $quantity = null)
    {
        $this->id = $id;
        $this->quantity = $quantity;
    }
}
