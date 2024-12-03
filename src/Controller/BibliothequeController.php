<?php

namespace App\Controller;

use App\Entity\Bibliotheque;
use App\Form\BibliothequeType;
use App\Repository\BibliothequeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/bibliotheque')]
final class BibliothequeController extends AbstractController
{
    #[Route(name: 'app_bibliotheque_index', methods: ['GET'])]
    public function index(BibliothequeRepository $bibliothequeRepository): Response
    {
        return $this->render('bibliotheque/index.html.twig', [
            'bibliotheques' => $bibliothequeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_bibliotheque_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bibliotheque = new Bibliotheque();
        $form = $this->createForm(BibliothequeType::class, $bibliotheque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bibliotheque);
            $entityManager->flush();

            return $this->redirectToRoute('app_Admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bibliotheque/new.html.twig', [
            'bibliotheque' => $bibliotheque,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bibliotheque_show', methods: ['GET'])]
    public function show(Bibliotheque $bibliotheque): Response
    {
        return $this->render('bibliotheque/show.html.twig', [
            'bibliotheque' => $bibliotheque,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_bibliotheque_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bibliotheque $bibliotheque, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BibliothequeType::class, $bibliotheque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_Admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bibliotheque/edit.html.twig', [
            'bibliotheque' => $bibliotheque,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bibliotheque_delete', methods: ['POST'])]
    public function delete(Request $request, Bibliotheque $bibliotheque, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bibliotheque->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($bibliotheque);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_Admin', [], Response::HTTP_SEE_OTHER);
    }
}
