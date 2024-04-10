<?php

namespace App\Services;

class OrderService
{
    public static function total(array $orders): float
    {
        if (count($orders) <= 0) return 0;

        return collect($orders)->reduce(function ($carry, $item) {
            return $carry + $item['subTotal'];
        }, 0);
    }
}
