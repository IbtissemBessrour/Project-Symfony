<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/reservation')]
final class ReservationController extends AbstractController
{
    #[Route('/', name: 'app_reservation_index', methods: ['GET'])]
    public function index(ReservationRepository $reservationRepository, Request $request): Response
    {
        // Récupération des valeurs de recherche depuis la requête GET
        $searchNomClient = $request->query->get('searchNomClient', '');
        $searchEmailClient = $request->query->get('searchEmailClient', '');
        $searchDate = $request->query->get('searchDate', '');

        // Création de la requête pour récupérer les réservations
        $queryBuilder = $reservationRepository->createQueryBuilder('r');

        // Appliquer les filtres de recherche
        if ($searchNomClient) {
            $queryBuilder->andWhere('r.nomClient LIKE :nomClient')
                         ->setParameter('nomClient', '%' . $searchNomClient . '%');
        }

        if ($searchEmailClient) {
            $queryBuilder->andWhere('r.emailClient LIKE :emailClient')
                         ->setParameter('emailClient', '%' . $searchEmailClient . '%');
        }

        if ($searchDate) {
            $queryBuilder->andWhere('r.date >= :date')
                         ->setParameter('date', new \DateTime($searchDate));
        }

        // Appliquer le tri
        $sort = $request->query->get('sort', 'r.date');
        $order = $request->query->get('order', 'ASC');
        $queryBuilder->orderBy($sort, $order);

        // Récupérer les réservations filtrées
        $reservations = $queryBuilder->getQuery()->getResult();

        // Retourner la vue avec les résultats
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations,
            'searchNomClient' => $searchNomClient,
            'searchEmailClient' => $searchEmailClient,
            'searchDate' => $searchDate,
        ]);
    }

    #[Route('/new', name: 'app_reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_show', methods: ['GET'])]
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_reservation_index');
        }

        return $this->render('reservation/edit.html.twig', [
            'form' => $form->createView(),
            'reservation' => $reservation,
        ]);
    }
}