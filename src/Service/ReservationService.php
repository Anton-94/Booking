<?php

namespace App\Service;

use App\DTO\ApartmentFilter;
use App\Entity\Apartment;
use App\Entity\Reservation;
use App\Enum\ApartmentEnum;
use App\Repository\ReservationRepository;

class ReservationService
{
    private ReservationRepository $repository;
    private ApartmentService $apartmentService;

    public function __construct(ReservationRepository  $repository, ApartmentService  $apartmentService)
    {
        $this->repository = $repository;
        $this->apartmentService = $apartmentService;
    }

    public function create(Apartment $apartment, ApartmentFilter $reservationData)
    {
        $guests = ApartmentEnum::isFlat($reservationData->getApartmentType()) ? $apartment->getSlots() : $reservationData->getGuests();
        $startDate = $reservationData->getStartDate();
        $endDate = $reservationData->getEndDate();

        $price = $this->apartmentService->calculatePrice($apartment->getPrice(), $guests, $startDate, $endDate);

        $reservation = new Reservation();
        $reservation->setApartment($apartment);
        $reservation->setStartDate($startDate);
        $reservation->setEndDate($endDate);
        $reservation->setGuests($guests);
        $reservation->setPrice($price);

        $this->repository->update($reservation);
    }
}