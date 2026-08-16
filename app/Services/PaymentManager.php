<?php
namespace App\Services;

final class PaymentManager
{
    public function providers(): array
    {
        return ['stripe'=>'Stripe','razorpay'=>'Razorpay','cashfree'=>'Cashfree','payu'=>'PayU'];
    }

    public function verify(string $provider, array $payload, array $credentials): array
    {
        return ['verified'=>false, 'message'=>ucfirst($provider).' verification is configurable from the admin panel and must be completed server-side before activation.'];
    }
}
