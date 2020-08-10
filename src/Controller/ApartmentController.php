<?php

namespace App\Controller;

use App\Entity\Apartment;
use App\Service\ReservationService;
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
    private ReservationService $reservationService;
    private SessionInterface $session;
    private LoggerInterface $logger;

    public function __construct(
        ReservationService $reservationService,
        SessionInterface $session,
        LoggerInterface $logger
    )
    {
        $this->reservationService = $reservationService;
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

        try {
            $this->reservationService->create($apartment, $reservationData);

            $this->addFlash('success', 'flushMessage.success');
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage(), ['exception' => $e]);
            $this->addFlash('error', 'flushMessage.error');
        }

        return $this->render('reservation/finished.html.twig');
    }
}