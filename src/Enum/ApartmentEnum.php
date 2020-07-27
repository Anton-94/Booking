<?php

namespace App\Enum;

class ApartmentEnum
{
    public const FLAT = 1;
    public const BED = 2;

    public static function getApartmentTypes(): array
    {
        return [
          self::FLAT => 'apartment.flat',
          self::BED => 'apartment.bed',
        ];
    }

    public static function isFlat(int $apartmentType): bool
    {
        return $apartmentType === self::FLAT;
    }

    public static function isBed(int $apartmentType): bool
    {
        return $apartmentType === self::BED;
    }
}