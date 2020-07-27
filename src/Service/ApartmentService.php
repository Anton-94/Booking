<?php

namespace App\Service;

use App\DiscountUtil;
use App\Repository\ApartmentRepository;

class ApartmentService
{
    private ApartmentRepository $repository;

    public function __construct(ApartmentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findApartmentsByParams(array $params): array
    {
        return $this->repository->findApartmentsByParams($params);
    }

    public function calculatePrice(float $price, int $guests, \DateTimeInterface $startDate, \DateTimeInterface $endDate): float
    {
        $priceForOneSlot = DiscountUtil::calculateDiscount($price, $startDate, $endDate);
        return $priceForOneSlot * $guests;
    }
}