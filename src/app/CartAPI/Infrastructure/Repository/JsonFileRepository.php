<?php

namespace App\CartAPI\Infrastructure\Repository;

use App\CartAPI\Domain\Contracts\Persistence\DataRepository;
use App\CartAPI\Domain\Model\Cart;
use App\CartAPI\Domain\Model\CartItem;

class JsonFileRepository implements DataRepository
{
    private $dataPath;

    /**
     * Prepara el archivo de datos
     * @param RepositoryConfiguration $config
     * @return void
     */
    public function __construct(RepositoryConfiguration $config)
    {
        $this->dataPath = $config->getPath();
    }

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
        $cartData = $this->getData($cart);

        // Busca si ese Item existe en la lista para subir su quantity
        $found = false;
        foreach ($cartData as $key => $_data) {
            if ($cartData[$key]["id"] == $item->getProduct()->getId()) {
                $cartData[$key]["qty"]++;

                $found = true;
            }
        }

        if (!$found) {
            $cartData[] = [
                "id" => $item->getProduct()->getId(),
                "qty" => 1
            ];
        }

        $this->saveData($cart, $cartData);
    }

    /**
     * @inheritDoc
     */
    public function deleteItem(Cart $cart, CartItem $item)
    {
        $cartData = $this->getData($cart);

        // Busca si ese Item existe en la lista para bajar su quantity
        foreach ($cartData as $key => $_data) {
            if ($cartData[$key]["id"] == $item->getProduct()->getId()) {
                $cartData[$key]["qty"]--;

                if ($cartData[$key]["qty"] == 0) {
                    unset($cartData[$key]);
                }
            }
        }

        $this->saveData($cart, $cartData);
    }

    /**
     * @inheritDoc
     */
    public function deleteItemAll(Cart $cart, CartItem $item)
    {
        $cartData = $this->getData($cart);

        // Busca si ese Item existe en la lista para eliminarlo del carrito
        foreach ($cartData as $key => $_data) {
            if ($cartData[$key]["id"] == $item->getProduct()->getId()) {
                unset($cartData[$key]);
            }
        }

        $this->saveData($cart, $cartData);
    }

    /**
     * @inheritDoc
     */
    public function clear(Cart $cart)
    {
        $cartId = $cart->getId();
        $filePath = $this->getFilePath($cartId);

        // Borra carrito
        try {
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $result = true;
        } catch (\Throwable $th) {
            $result = false;
        }

        return $result;
    }

    protected function getData(Cart $cart)
    {
        $id = $cart->getId();

        $filePath = $this->getFilePath($id);

        if (!file_exists($filePath)) {
            return [];
        }

        $jsonData = file_get_contents($filePath);
        return json_decode($jsonData, true) ?: [];
    }

    protected function saveData(Cart $cart, array $cartData)
    {
        $id = $cart->getId();

        $filePath = $this->getFilePath($id);

        $jsonData = json_encode($cartData, JSON_PRETTY_PRINT);

        file_put_contents($filePath, $jsonData);

        return $this;
    }

    protected function getFilePath($cartId)
    {
        return $this->dataPath . '/cart_' . $cartId . '.json';
    }
}

