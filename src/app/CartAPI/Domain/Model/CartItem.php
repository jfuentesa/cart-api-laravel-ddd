<?php

namespace App\CartAPI\Domain\Model;

/**
 * Clase que representa los items del carrito
 */
class CartItem
{
    /**
     * Producto
     * @var Product $product
     */
    public $product;

    /**
     * Cantidad
     * @var int $quantity
     */
    public $quantity;

    /**
     * Get $product
     *
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set $product
     *
     * @param Product $product  $product
     *
     * @return self
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get $quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set $quantity
     *
     * @param int $quantity  $quantity
     *
     * @return self
     */
    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }
}
