<?php

namespace Tests\Feature\Service;

use App\CartAPI\Domain\Model\Cart;
use App\CartAPI\Domain\Model\CartItem;

class CartServiceMockup
{
    protected $dummyData = [
        0 => [],
        1 => [
            [
                "id" => 1,
                "qty" => 5
            ]
        ],
    ];

    /**
     * @inheritDoc
     */
    public function list(Cart $cart)
    {
        return $this->getData($cart);
    }

    /**
     * @inheritDoc
     */
    public function addItem(Cart $cart, CartItem $item)
    {

    }

    /**
     * @inheritDoc
     */
    public function deleteItem(Cart $cart, CartItem $item)
    {

    }

    /**
     * @inheritDoc
     */
    public function deleteItemAll(Cart $cart, CartItem $item)
    {

    }

    /**
     * @inheritDoc
     */
    public function clear(Cart $cart)
    {
        return true;
    }

    /**
     * Datos dummy
     * @param Cart $cart
     * @return array
     */
    protected function getData(Cart $cart)
    {
        return $this->dummyData[$cart->getId()];
    }

}

