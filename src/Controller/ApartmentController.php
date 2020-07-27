<?php

namespace App\Controller;

use App\Entity\Apartment;
use App\Entity\Reservation;
use App\Enum\ApartmentEnum;
use App\Service\ApartmentService;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/apartment", name="apartment_")
 */
class ApartmentController extends AbstractController
{
    private ApartmentService $apartmentService;
    private SessionInterface $session;
    private LoggerInterface $logger;

    public function __construct(
        ApartmentService $apartmentService,
        SessionInterface $session,
        LoggerInterface $logger
    )
    {
        $this->apartmentService = $apartmentService;
        $this->session = $session;
        $this->logger = $logger;
    }

    /**
     * @Route("/reservation/{id}", name="reservation")
     * @ParamConverter("apartament", options={"id" = "id"})
     */
    public function reservation(Apartment $apartment): Response
    {
        $reservationData = $this->session->get('reservationData');
        $guests = ApartmentEnum::isFlat($reservationData['apartmentType']) ? $apartment->getSlots() : $reservationData['guests'];
        $startDate = $reservationData['startDate'];
        $endDate = $reservationData['endDate'];

        $price = $this->apartmentService->calculatePrice($apartment->getPrice(), $guests, $startDate, $endDate);

        try {
            $reservation = new Reservation();
            $reservation->setApartment($apartment);
            $reservation->setStartDate($startDate);
            $reservation->setEndDate($endDate);
            $reservation->setGuests($guests);
            $reservation->setPrice($price);

            $em = $this->getDoctrine()->getManager();
            $em->persist($reservation);
            $em->flush();

            $this->addFlash('success', 'flushMessage.success');
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage(), ['exception' => $e]);
            $this->addFlash('error', 'flushMessage.error');
        }

        return $this->render('reservation/finished.html.twig');
    }
}