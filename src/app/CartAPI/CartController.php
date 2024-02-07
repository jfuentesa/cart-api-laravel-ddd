<?php

namespace App\CartAPI;

use App\CartAPI\Application\Service\CartService;
use App\CartAPI\Domain\Contracts\Gateway\PaymentGateway;
use App\CartAPI\Domain\Enum\Products;
use App\CartAPI\Domain\Model\Cart;
use App\CartAPI\Domain\Model\CartItem;
use App\CartAPI\Shared\Factory\CartRepositoryFactory;
use App\CartAPI\Shared\Factory\PaymentGatewayFactory;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * Controlador del carrito
 */
class CartController extends Controller
{
    /**
     * Servicio de operaciones con carrito
     * @var CartService $service
     */
    protected $service;

    /**
     * Pasarela de pago
     * @var PaymentGateway $paymentGw
     */
    protected $paymentGw;

    /**
     * Repositorio de productos.
     * Idealmente esto iría en una base de datos.
     * @var Products $products
     */
    protected $products;

    /**
     * Prepara el controller para el carrito.
     * Crea gateways/repository aquí para hacerlo independiente del framework.
     * @return void
     */
    public function __construct($service = null, $paymentGw = null)
    {
        if ($paymentGw) {
            $this->paymentGw = $paymentGw;
        } else {
            // Prepara gateway de pago
            $this->paymentGw = PaymentGatewayFactory::create();
        }

        if ($service) {
            $this->service = $service;
        } else {
            // Prepara el gateway, y lo guarda como servicio.
            $this->service = new CartService(CartRepositoryFactory::create());
        }

        $this->products = new Products();
    }

    /**
     * Lista el carrito
     * @param int $cartId
     * @return JsonResponse
     */
    public function list(int $cartId)
    {
        $cart = (new Cart())->setId($cartId);

        $cartData = $this->service->list($cart);

        // Agregar descripciones, para no almacenarlas en el carrito
        foreach ($cartData as $_key => $_data) {
            $product = $this->products->get($_data["id"]);
            $cartData[$_key]["description"] = $product->getDescription();
            $cartData[$_key]["price"] = $product->getPrice();
        }

        $cart->setData($cartData);

        return response()->json([
            "items" => $cart->getData(),
            "subtotal" => number_format(round($cart->calculateTotal(), 2), 2, '.', '0'),
            "total" => number_format(round($cart->calculateTotalPlusTaxes(), 2), 2, '.', '0'),
        ]);
    }

    /**
     * Agrega item al carrito
     * @param int $cartId
     * @param int $productId
     * @return JsonResponse
     */
    public function addItem(int $cartId, int $productId)
    {
        $product = $this->products->get($productId);

        $cart = (new Cart())->setId($cartId);
        $item = (new CartItem())->setProduct($product);

        $this->service->addItem($cart, $item);

        return $this->list($cartId);
    }

    /**
     * Elimina un item
     * @param mixed $cartId
     * @param mixed $productId
     * @return JsonResponse
     */
    public function deleteItem($cartId, $productId)
    {
        $product = $this->products->get($productId);

        $cart = (new Cart())->setId($cartId);
        $item = (new CartItem())->setProduct($product);

        $this->service->deleteItem($cart, $item);

        return $this->list($cartId);
    }

    /**
     * Borra todos los items correspondientes a un producto concreto
     * @param mixed $cartId
     * @param mixed $productId
     * @return JsonResponse
     */
    public function deleteItemAll($cartId, $productId)
    {
        $product = $this->products->get($productId);

        $cart = (new Cart())->setId($cartId);
        $item = (new CartItem())->setProduct($product);

        $this->service->deleteItemAll($cart, $item);

        return $this->list($cartId);
    }

    /**
     * Borra todo el carrito
     * @param mixed $cartId
     * @return JsonResponse
     */
    public function clear($cartId)
    {
        $cart = (new Cart())->setId($cartId);

        $this->service->clear($cart);

        return $this->list($cartId);
    }

    /**
     * Pago del carrito
     * @return JsonResponse
     */
    public function pay($cartId)
    {
        $cart = (new Cart())->setId($cartId);

        // Toma la lista de productos desde el servicio
        $cart->setData($this->service->list($cart));

        $total = $cart->calculateTotal();

        // Devuelve true/false en función del resultado del pago
        $paid = $this->paymentGw->processPayment($total);

        if ($paid) {
            $this->service->clear($cart);
        }

        return $this->list($cartId);
    }
}
