<?php

namespace App\CartAPI\Application\Service;

use App\CartAPI\Domain\Model\Cart;
use App\CartAPI\Domain\Model\CartItem;
use App\CartAPI\Infrastructure\Repository\CartRepository;
use Illuminate\Support\Collection;

class CartService
{
    /**
     * Id de carrito
     * @var int
     */
    protected $cartId;

    /**
     * Repositorio de carritos
     * @var CartRepository
     */
    protected $repo;

    public function __construct(CartRepository $repo) {
        $this->repo = $repo;
    }

    /**
     * Lista los items del carrito
     * @return Collection
     */
    public function list(Cart $cart)
    {
        return $this->repo->list($cart);
    }

    public function addItem(Cart $cart, CartItem $item)
    {
        $this->repo->addItem($cart, $item);
    }

    public function deleteItem(Cart $cart, CartItem $item)
    {
        $this->repo->deleteItem($cart, $item);
    }

    public function deleteItemAll(Cart $cart, CartItem $item)
    {
        $this->repo->deleteItemAll($cart, $item);
    }

    public function clear(Cart $cart)
    {
        $this->repo->clear($cart);
    }
}
