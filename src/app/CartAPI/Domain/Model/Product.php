<?php

namespace App\CartAPI\Domain\Model;

use App\CartAPI\Shared\Traits\HasId;

/**
 * Clase que representa los productos en la supuesta base de datos
 */
class Product
{
    use HasId;

    /**
     * Descripción del producto
     * @var string
     */
    public $description;

    /**
     * Precio del producto
     * @var string
     */
    public $price;

    /**
     * Get descripción del producto
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set descripción del producto
     * @param mixed $description  Descripción del producto
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get precio del producto
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set precio del producto
     *
     * @param string $price  Precio del producto
     *
     * @return self
     */
    public function setPrice(string $price)
    {
        $this->price = $price;

        return $this;
    }
}
