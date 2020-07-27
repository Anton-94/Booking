<?php

namespace App;

class DiscountUtil
{
    const MAX_PERCENT = 100;
    const DISCOUNT_PERCENT = 20;
    const DISCOUNT_DAYS = 7;

    public static function calculateDiscount(float $price, \DateTimeInterface $startDate, \DateTimeInterface $endDate): float
    {
        $diffDate = $startDate->diff($endDate);

        if ($diffDate->days > self::DISCOUNT_DAYS) {
            $price = $diffDate->days * ($price - ((self::DISCOUNT_PERCENT / self::MAX_PERCENT) * $price));
        }

        return $price;
    }
}