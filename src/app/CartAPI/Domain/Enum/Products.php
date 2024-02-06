<?php

namespace App\CartAPI\Domain\Enum;

use App\CartAPI\Domain\Model\Product;
use Exception;

/**
 * Listado de productos.
 * Lo interesante sería meter esto en una base de datos.
 */
class Products
{
    public $products;

    /**
     * Crea la lista dummy de productos
     * @return void
     */
    public function __construct() {
        $product = new Product();
        $product->setId(1);
        $product->setDescription("Zapatillas deportivas");
        $product->setPrice("49.95");

        $this->add($product);

        $product = new Product();
        $product->setId(2);
        $product->setDescription("Pantalones de chándal");
        $product->setPrice("27.95");

        $this->add($product);

        $product = new Product();
        $product->setId(3);
        $product->setDescription("Sudadera");
        $product->setPrice("33.50");

        $this->add($product);
    }

    /**
     * Toma un producto concreto
     * @return Product
     */
    public function get($id)
    {
        if (!isset($this->products[$id])) {
            throw new Exception("Producto no existe");

        }

        return $this->products[$id];
    }

    /**
     * Agrega un producto a la lista
     * @return Product
     */
    public function add(Product $product)
    {
        $this->products[$product->getId()] = $product;
    }


    /**
     * Getter
     * @return array
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Setter
     * @return self
     */
    public function setProducts($products)
    {
        $this->products = $products;

        return $this;
    }
}
