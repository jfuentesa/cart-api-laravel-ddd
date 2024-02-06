<?php

namespace App\CartAPI\Infrastructure\Gateway\Payment;

use App\CartAPI\Domain\Contracts\Gateway\PaymentGateway;

class DummyPaymentGateway implements PaymentGateway
{
    /**
     * Hace el pago en la pasarela o devuelve false
     * @param mixed $amount
     * @param string $currency
     * @return true
     */
    public function processPayment($amount, $currency = "EUR")
    {
        return true;
    }

    /**
     * Hace el pago en la pasarela o devuelve false
     * @param mixed $transactionId
     * @return array
     */
    public function checkPayment($transactionId)
    {
        // ... Tomar datos desde pasarela de pago ...
        $transactionId = "00000000000";

        return [
            "transaction_id" => $transactionId,
            "status" => "paid"
        ];
    }

}
