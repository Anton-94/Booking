<?php

namespace App\Controller;

use App\Form\SearchApartmentType;
use App\Service\ApartmentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @var ApartmentService
     */
    private ApartmentService $apartmentService;

    /**
     * @var SessionInterface
     */
    private SessionInterface $session;

    public function __construct(ApartmentService $apartmentService, SessionInterface $session)
    {
        $this->apartmentService = $apartmentService;
        $this->session = $session;
    }

    /**
     * @Route("/", name="main")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(SearchApartmentType::class, null, [
            'method' => 'GET',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $apartments = $this->apartmentService->findApartmentsByParams($form->getData());
            $this->session->set('reservationData', $form->getData());

            return $this->render('apartment/listing.html.twig', [
                'apartments' => $apartments,
            ]);
        }

        return $this->render('index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}