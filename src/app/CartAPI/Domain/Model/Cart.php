<?php

namespace App\CartAPI\Domain\Model;

use App\CartAPI\Domain\Enum\Products;
use App\CartAPI\Shared\Traits\HasId;

class Cart
{
    use HasId;

    /**
     * Porcentaje de impuestos
     * @var int
     */
    const TAX_AMOUNT = 21;

    protected $data;

    /**
     * Calcula el total del carrito sin impuestos
     * @return int|float
     */
    public function calculateTotal()
    {
        $subTotal = 0;
        if (isset($this->data)) {
            foreach ($this->data as $_item) {
                $product = (new Products())->get($_item["id"]);

                $subTotal += (float) ($product->getPrice() * $_item["qty"]);
            }
        }

        return $subTotal;
    }

    /**
     * Calcula el total del carrito con impuestos
     * @return mixed
     */
    public function calculateTotalPlusTaxes()
    {
        $total = $this->calculateTotal();

        return $total + ($total * (self::TAX_AMOUNT / 100));
    }

    /**
     * Get the value of data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the value of data
     *
     * @return  self
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }
}
