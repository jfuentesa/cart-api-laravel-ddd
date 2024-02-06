<?php

namespace App\CartAPI\Shared\Factory;

use App\CartAPI\Infrastructure\Repository\CartRepository;
use App\CartAPI\Infrastructure\Repository\RepositoryConfiguration;

/**
 * Crea repositorio de carrito
 */
class CartRepositoryFactory
{
    const CONFIG_PATH = __DIR__ . "/../../../../storage/carts";

    public static function create()
    {
        // Prepara repositorio de datos (almacenar carritos)
        $repositoryConfiguration = new RepositoryConfiguration();
        $repositoryConfiguration->setPath(self::CONFIG_PATH);

        $dataRepository = new CartRepository($repositoryConfiguration);

        return $dataRepository;
    }
}
