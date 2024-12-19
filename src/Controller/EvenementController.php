<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;



#[Route('/evenement')]
class EvenementController extends AbstractController
{
    private $entityManager;

    // Injection du gestionnaire d'entités via le constructeur
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_evenement_index', methods: ['GET'])]
    public function index(EvenementRepository $evenementRepository, Request $request): Response
    {
        // Récupération des valeurs de recherche depuis la requête GET
        $searchNom = $request->query->get('searchNom', '');
        $searchType = $request->query->get('searchType', '');
        $searchDate = $request->query->get('searchDate', '');

        // Création de la requête pour récupérer les événements
        $queryBuilder = $evenementRepository->createQueryBuilder('e');

        // Appliquer les filtres de recherche
        if ($searchNom) {
            $queryBuilder->andWhere('e.nomEvenement LIKE :nom')
                         ->setParameter('nom', '%' . $searchNom . '%');
        }

        if ($searchType) {
            $queryBuilder->andWhere('e.typeEvenement = :type')
                         ->setParameter('type', $searchType);
        }

        if ($searchDate) {
            $queryBuilder->andWhere('e.dateEvenement >= :date')
                         ->setParameter('date', new \DateTime($searchDate));
        }

        // Appliquer le tri
        $sort = $request->query->get('sort', 'dateEvenement');
        $order = $request->query->get('order', 'ASC');
        $queryBuilder->orderBy('e.' . $sort, $order);

        // Récupérer les événements filtrés
        $evenements = $queryBuilder->getQuery()->getResult();

        // Retourner la vue avec les résultats
        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenements,
            'searchNom' => $searchNom,
            'searchType' => $searchType,
            'searchDate' => $searchDate,
        ]);
    }
   

    #[Route('/new', name: 'app_evenement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index');
        }

        return $this->render('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }
    #[Route('/{id}', name: 'app_evenement_show', methods: ['GET'])]
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

#[Route('/{id}/edit', name: 'app_evenement_edit', methods: ['GET', 'POST'])]
public function edit(Evenement $evenement, Request $request, EntityManagerInterface $entityManager): Response
{
    $form = $this->createForm(EvenementType::class, $evenement);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();
        return $this->redirectToRoute('app_evenement_index');
    }

    return $this->render('evenement/edit.html.twig', [
        'evenement' => $evenement,
        'form' => $form->createView(),
    ]);
}
#[Route('/{id}', name: 'app_evenement_delete', methods: ['POST'])]
    public function delete(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_Etudient', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/count', name: 'app_evenement_count', methods: ['GET'])]
    public function countEvenements(Request $request)
    {
        // Récupérer les paramètres de la requête (les filtres)
        $type = $request->query->get('type');
        $date = $request->query->get('date'); // Remplacer dateDebut et dateFin par date

        // Logique pour filtrer les événements en fonction des filtres
        $evenementsQuery = $this->entityManager->getRepository(Evenement::class)
            ->createQueryBuilder('e')
            ->select('e')
            ->where('1=1'); // Condition par défaut (toujours vrai)

        // Appliquer le filtre par type
        if ($type) {
            $evenementsQuery->andWhere('e.typeEvenement = :type')
                             ->setParameter('type', $type);
        }

        // Appliquer le filtre par date
        if ($date) {
            $evenementsQuery->andWhere('e.dateEvenement = :date')
                             ->setParameter('date', $date);
        }

        // Exécuter la requête
        $evenements = $evenementsQuery->getQuery()->getResult();

        // Retourner le nombre d'événements filtrés
        return new JsonResponse([
            'count' => count($evenements)
        ]);
    }
}