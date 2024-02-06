<?php

namespace App\CartAPI\Shared\Factory;

use App\CartAPI\Infrastructure\Gateway\Payment\DummyPaymentGateway;

/**
 * Crea pasarela de pago
 */
class PaymentGatewayFactory
{
    public static function create()
    {
        return new DummyPaymentGateway();
    }
}
