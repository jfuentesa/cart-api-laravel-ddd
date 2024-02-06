<?php

namespace App\CartAPI\Domain\Contracts\Persistence;

use App\CartAPI\Domain\Model\Cart;
use App\CartAPI\Domain\Model\CartItem;

interface DataRepository
{
    /**
     * Lista el carrito
     * @param Cart $cart
     * @return array
     */
    public function list(Cart $cart);

    /**
     * Agrega al carrito
     * @param Cart $cart
     * @param CartItem $item
     * @return self
     */
    public function addItem(Cart $cart, CartItem $item);

    /**
     * Borra del carrito
     * @param Cart $cart
     * @param CartItem $item
     * @return mixed
     */
    public function deleteItem(Cart $cart, CartItem $item);

    /**
     * Borra todos los elementos de un determinado item
     * @param Cart $cart
     * @param CartItem $item
     * @return mixed
     */
    public function deleteItemAll(Cart $cart, CartItem $item);

    /**
     * Vacía el carrito
     * @param Cart $cart
     * @return mixed
     */
    public function clear(Cart $cart);
}
