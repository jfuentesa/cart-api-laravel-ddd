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
use Illuminate\Contracts\Container\BindingResolutionException;

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
     * Prepara el controller para el carrito.
     * Crea gateways/repository aquí para hacerlo independiente del framework.
     * @return void
     */
    public function __construct()
    {
        // Prepara gateway de pago
        $this->paymentGw = PaymentGatewayFactory::create();

        // Prepara el gateway, y lo guarda como servicio.
        $this->service = new CartService(CartRepositoryFactory::create());
    }

    /**
     * Lista el carrito
     * @param int $cartId
     * @return JsonResponse
     */
    public function list(int $cartId)
    {
        $cart = (new Cart())->setId($cartId);

        $products = new Products();

        $cartData = $this->service->list($cart);

        // Agregar descripciones, para no almacenarlas
        foreach ($cartData as $_key => $_data) {
            $product = $products->get($_data["id"]);
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
        $product = (new Products())->get($productId);

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
        $product = (new Products())->get($productId);

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
        $product = (new Products())->get($productId);

        $cart = (new Cart())->setId($cartId);
        $item = (new CartItem())->setProduct($product);

        $this->service->deleteItemAll($cart, $item);

        return $this->list($cartId);
    }

    /**
     * Borra todo el carrito
     * @param mixed $cartId
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function clear($cartId)
    {
        $cart = (new Cart())->setId($cartId);

        $this->service->clear($cart);

        return $this->list($cartId);
    }

    /**
     * Pago del carrito
     * @return bool
     */
    public function pay($cartId)
    {
        $cart = (new Cart())->setId($cartId)->setData($this->service->list($cartId));

        $total = $cart->calculateTotal();

        // Devuelve true/false en función del resultado del pago
        $paid = $this->paymentGw->processPayment($total);

        if ($paid) {
            $this->service->clear($cart);
        }

        return $this->list($cartId);
    }
}
