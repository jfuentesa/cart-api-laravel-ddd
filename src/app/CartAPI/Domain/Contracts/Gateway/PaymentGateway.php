<?php

namespace App\CartAPI\Domain\Contracts\Gateway;

interface PaymentGateway
{
    public function processPayment($amount, $currency = "EUR");

    public function checkPayment($transactionId);

}
