<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;
use App\CartAPI\CartController;
use Illuminate\Http\JsonResponse;
use Tests\Feature\Gateway\PaymentGatewayMockup;
use Tests\Feature\Service\CartServiceMockup;


class ControllerTest extends TestCase
{
    /**
     * @return void
     */
    public function testGettingAnEmptyList()
    {
        $controller = $this->controllerFactory();

        $response = $controller->list(0);

        $this->assertInstanceOf(JsonResponse::class, $response);

        $this->assertStringContainsString('{"items":[],"subtotal":"0.00","total":"0.00"}', $response->content());

        $this->assertJson($response->content());
    }

    /**
     * @return void
     */
    public function testGettingAList()
    {
        $controller = $this->controllerFactory();

        $response = $controller->list(1);

        $this->assertInstanceOf(JsonResponse::class, $response);

        $this->assertJson($response->content());
    }

    /**
     *
     * @return void
     */
    public function testAddAnItemToACart()
    {
        $controller = $this->controllerFactory();

        $response = $controller->addItem(0, 1);

        $this->assertInstanceOf(JsonResponse::class, $response);

        $this->assertJson($response->content());
    }

    /**
     *
     * @return void
     */
    public function testDeleteAnItem()
    {
        $controller = $this->controllerFactory();

        $response = $controller->deleteItem(0, 1);

        $this->assertInstanceOf(JsonResponse::class, $response);

        $this->assertJson($response->content());
    }

    /**
     *
     * @return void
     */
    public function testDeleteAProductFromACart()
    {
        $controller = $this->controllerFactory();

        $response = $controller->deleteItemAll(0, 1);

        $this->assertInstanceOf(JsonResponse::class, $response);

        $this->assertJson($response->content());
    }

    /**
     *
     * @return void
     */
    public function testClearACart()
    {
        $controller = $this->controllerFactory();

        $response = $controller->clear(0, 0);

        $this->assertInstanceOf(JsonResponse::class, $response);

        $this->assertJson($response->content());
    }

    /**
     *
     * @return void
     */
    public function testPayACart()
    {
        $controller = $this->controllerFactory();

        $response = $controller->pay(1);

        $this->assertInstanceOf(JsonResponse::class, $response);

        $this->assertJson($response->content());
    }

    /**
     * Factory del controller dummy
     * @return CartController
     */
    protected function controllerFactory()
    {
        $controller = new CartController(
            new CartServiceMockup(),
            new PaymentGatewayMockup(),
        );

        return $controller;
    }
}
