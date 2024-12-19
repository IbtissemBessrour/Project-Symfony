<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\SessionType;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
 


#[Route('/session')]
final class SessionController extends AbstractController
{
    /*#[Route('/', name: 'app_session_index', methods: ['GET'])]
    public function index(SessionRepository $sessionRepository): Response
    {
        return $this->render('session/index.html.twig', [
            'sessions' => $sessionRepository->findAll(),
        ]);
    }*/
/**
 * New
 */
#[Route('/', name: 'app_session_index', methods: ['GET'])]
    public function index(SessionRepository $sessionRepository,  Request $request): Response
    {
        // Récupération des valeurs de recherche depuis la requête GET
        $searchNom = $request->query->get('searchNom', '');
        // Création de la requête pour récupérer les événements
        $queryBuilder = $sessionRepository->createQueryBuilder('e');
        // Appliquer les filtres de recherche
        if ($searchNom) {
            $queryBuilder->andWhere('e.nomFormation LIKE :nom')
                         ->setParameter('nom', '%' . $searchNom . '%');
        }
        // Appliquer le tri
        $sort = $request->query->get('sort', 'dateDebue');
        $order = $request->query->get('order', 'ASC');
        $queryBuilder->orderBy('e.' . $sort, $order);
        // Récupérer les formation filtrés
        $sessions = $queryBuilder->getQuery()->getResult();
        return $this->render('session/index.html.twig', [
            'sessions' => $sessions,
            'searchNom' => $searchNom,
        ]);
    }
/**
 * End new
 */
    #[Route('/new', name: 'app_session_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $session = new Session();
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($session);
            $entityManager->flush();

            return $this->redirectToRoute('app_Session', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('session/new.html.twig', [
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_session_show', methods: ['GET'])]
    public function show(Session $session): Response
    {
        return $this->render('session/show.html.twig', [
            'session' => $session,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_session_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Session $session, EntityManagerInterface $entityManager): Response
    {
       
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_Session', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('session/edit.html.twig', [
            'session' => $session,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_session_delete', methods: ['POST'])]
    public function delete(Request $request, Session $session, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$session->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($session);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_Session', [], Response::HTTP_SEE_OTHER);
    }
}
