<?php

namespace App\Twig;

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
        $reservationData = $this->session->get('reservationData');
        $guests = ApartmentEnum::isFlat($reservationData['apartmentType']) ? $slots : $reservationData['guests'];

        return $this->apartmentService->calculatePrice($price, $guests, $reservationData['startDate'], $reservationData['endDate']);
    }
}