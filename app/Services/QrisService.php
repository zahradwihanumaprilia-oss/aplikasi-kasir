<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\CoreApi;

class QrisService
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function generateQrisCharge($orderId, $grossAmount)
    {
        $params = [
            'payment_type' => 'gopay', // Di Midtrans, QRIS biasanya menggunakan channel gopay/qris
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $grossAmount,
            ]
        ];

        return CoreApi::charge($params);
    }
}