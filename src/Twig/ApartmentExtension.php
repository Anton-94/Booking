<?php

namespace App\Twig;

use App\DTO\ApartmentFilter;
use App\Enum\ApartmentEnum;
use App\Service\ApartmentService;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ApartmentExtension extends AbstractExtension
{
    private SessionInterface $session;
    private ApartmentService $apartmentService;

    public function __construct(SessionInterface $session, ApartmentService $apartmentService)
    {
        $this->session = $session;
        $this->apartmentService = $apartmentService;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('calculatePrice', [$this, 'calculatePrice']),
        ];
    }

    public function calculatePrice(float $price, int $slots)
    {
        /** @var ApartmentFilter $reservationData */
        $reservationData = $this->session->get('reservationData');
        $guests = ApartmentEnum::isFlat($reservationData->getApartmentType()) ? $slots : $reservationData->getGuests();

        return $this->apartmentService->calculatePrice($price, $guests, $reservationData->getStartDate(), $reservationData->getEndDate());
    }
}