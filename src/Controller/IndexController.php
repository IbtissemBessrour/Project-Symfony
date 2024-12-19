<?php

namespace App\Controller;
use App\Repository\QuizRepository;
use App\Repository\UserRepository;
use App\Repository\SessionRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Bibliotheque;
use App\Entity\Evenement;
use App\Entity\Session;
use App\Entity\Formation;
use App\Entity\Quiz;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\FormationRepository;





class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('index/about.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    #[Route('/services', name: 'app_services')]
    public function services(): Response
    {
        return $this->render('index/services.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    #[Route('/blog', name: 'app_blog')]
    public function blog(): Response
    {
        return $this->render('index/blog.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    #[Route('/blog_grid', name: 'app_blog_grid')]
    public function blog_grid(): Response
    {
        return $this->render('index/blog_grid.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    #[Route('/blog_detail', name: 'app_blog_detail')]
    public function blog_detail(): Response
    {
        return $this->render('index/blog_detail.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    #[Route('/pages', name: 'app_pages')]
    public function pages(): Response
    {
        return $this->render('index/pages.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    #[Route('/pricing_plan', name: 'app_pricing_plan')]
    public function pricing_plan(): Response
    {
        return $this->render('index/pricing_plan.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    #[Route('/features', name: 'app_features')]
    public function features(): Response
    {
        return $this->render('index/features.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    #[Route('/membres', name: 'app_membres')]
    public function membres(): Response
    {
        return $this->render('index/membres.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    #[Route('/testimonial', name: 'app_testimonial')]
    public function testimonial(): Response
    {
        return $this->render('index/testimonial.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
   
    #[Route('/quote', name: 'app_quote')]
    public function quote(): Response
    {
        return $this->render('index/quote.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
    private $sessionRepository;
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager,SessionRepository $sessionRepository)
    {
        $this->entityManager = $entityManager;
        $this->sessionRepository = $sessionRepository;

    }

    #[Route('/Admin', name: 'app_Admin', methods: ['GET'])]
    public function Admin(UserRepository $UserRepository, Request $request): Response
    {
        // Récupération des valeurs de recherche depuis la requête GET
        $searchNom = $request->query->get('searchNom', '');
    
        // Création de la requête pour récupérer les utilisateurs
        $queryBuilder = $UserRepository->createQueryBuilder('u');
    
        // Appliquer les filtres de recherche
        if ($searchNom) {
            $queryBuilder->andWhere('u.nom LIKE :nom')
                         ->setParameter('nom', '%' . $searchNom . '%');
        }
    
        // Appliquer le tri
        $sort = $request->query->get('sort', 'prenom'); // Par défaut, tri par prénom
        $order = $request->query->get('order', 'ASC');  // Par défaut, ordre croissant
        $queryBuilder->orderBy('u.' . $sort, $order);
    
        // Récupérer les utilisateurs filtrés
        $users = $queryBuilder->getQuery()->getResult();
    
        // Récupérer les bibliothèques (ou d'autres données nécessaires)
        $bibliotheque = $this->entityManager->getRepository(Bibliotheque::class)->findAll();
    
        // Retourner la vue avec les données
        return $this->render('dashboard/DahAdmin.htlml.twig', [
            'searchNom' => $searchNom,
            'users' => $users,
            'bibliotheque' => $bibliotheque,
        ]);
    }

    #[Route('/Etudient', name: 'app_Etudient')]
    public function Etudient(): Response
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();
        $evenement = $this->entityManager->getRepository(Evenement::class)->findAll();
        return $this->render('dashboard/etudienDa.html.twig', [
            'users' => $users,
            'evenement' => $evenement,
        ]);
    }

    #[Route('/Fourmateur', name: 'app_Fourmateur')]
    public function Fourmateur(): Response
    {
        $formation = $this->entityManager->getRepository(Formation::class)->findAll();
        $session = $this->entityManager->getRepository(Session::class)->findAll();
        return $this->render('dashboard/fourmateurDa.html.twig', [
            'formation' => $formation,
            'session' => $session,
        ]);
    }

   /* #[Route('/four', name: 'app_four')]
    public function fourmateu(): Response
    {
        $user = $this->getUser();
        $formation = $this->entityManager->getRepository(Formation::class)->findAll();
        $session = $this->entityManager->getRepository(Session::class)->findAll();
        return $this->render('dashboard/DahNew.html.twig', [
            'formation' => $formation,
            'session' => $session,
            'user' => $user,
        ]);
    }*/
    /**
     * New
     */
    #[Route('/four', name: 'app_four', methods: ['GET'])]
    public function fourmateu(FormationRepository $formationRepository,SessionRepository $sessionRepository, Request $request): Response
    {
                // Appel de la méthode countSessionsToday() qui retourne un entier
                $sessionsToday = $this->sessionRepository->countSessionsToday(); 
                        //Callcule de nombre total de Session
    $totalSession = $sessionRepository->getTotalNombreSession();
        //Callcule de nombre total de formation
    $totalformation = $formationRepository->getTotalNombreFormation();
        //Callcule de nombre total de place
     $totalPlaces = $formationRepository->getTotalNombrePlaces();
       // Récupération des valeurs de recherche depuis la requête GET
     $searchNom = $request->query->get('searchNom', '');

        // Création de la requête pour récupérer les formations
    $queryBuilder = $formationRepository->createQueryBuilder('f');

       // Appliquer les filtres de recherche
     if ($searchNom) {
        $queryBuilder->andWhere('f.nomFormation LIKE :nom')
                  ->setParameter('nom', '%' . $searchNom . '%');
 }

 // Appliquer le tri
 $sort = $request->query->get('sort', 'nomFormation');
 $order = $request->query->get('order', 'ASC');
 $queryBuilder->orderBy('f.' . $sort, $order);

 // Récupérer les formations filtrées
 $formation = $queryBuilder->getQuery()->getResult();
        $user = $this->getUser();
        $formation = $this->entityManager->getRepository(Formation::class)->findAll();
        $session = $this->entityManager->getRepository(Session::class)->findAll();
        return $this->render('dashboard/DahNew.html.twig', [
            'searchNom' => $searchNom,
            'formation' => $formation,
            'session' => $session,
            'user' => $user,
            'totalPlaces' => $totalPlaces,
            'totalformation' => $totalformation,
            'totalSession' => $totalSession,
            'sessions_today' => $sessionsToday

        ]);
    }
/**
 * End New
 */
   /* #[Route('/fourt', name: 'app_Session')]
    public function Session(): Response
    {
        $user = $this->getUser();
        $formation = $this->entityManager->getRepository(Formation::class)->findAll();
        $session = $this->entityManager->getRepository(Session::class)->findAll();
        return $this->render('dashboard/DahNewSe.html.twig', [
            'formation' => $formation,
            'session' => $session,
            'user' => $user,
        ]);
    }*/

    #[Route('/fourt', name: 'app_Session' , methods: ['GET'])]
    public function Session(SessionRepository $sessionRepository,FormationRepository $formationRepository,  Request $request): Response
    {
        // Appel de la méthode countSessionsToday() qui retourne un entier
        $sessionsToday = $this->sessionRepository->countSessionsToday(); 
                //Callcule de nombre total de formation
    $totalformation = $formationRepository->getTotalNombreFormation();
                //Callcule de nombre total de place
     $totalPlaces = $formationRepository->getTotalNombrePlaces();
                //Callcule de nombre total de Session
    $totalSession = $sessionRepository->getTotalNombreSession();
         // Récupération des valeurs de recherche depuis la requête GET
 $searchNom = $request->query->get('searchNom', '');

 // Création de la requête pour récupérer les formations
 $queryBuilder = $sessionRepository->createQueryBuilder('f');

 // Appliquer les filtres de recherche
 if ($searchNom) {
     $queryBuilder->andWhere('f.nomFormation LIKE :nom')
                  ->setParameter('nom', '%' . $searchNom . '%');
 }

 // Appliquer le tri
 $sort = $request->query->get('sort', 'dateDebue');
 $order = $request->query->get('order', 'ASC');
 $queryBuilder->orderBy('f.' . $sort, $order);

 // Récupérer les formations filtrées
 $formation = $queryBuilder->getQuery()->getResult();
        $user = $this->getUser();
        $formation = $this->entityManager->getRepository(Formation::class)->findAll();
        $session = $this->entityManager->getRepository(Session::class)->findAll();
        return $this->render('dashboard/DahNewSe.html.twig', [
            'searchNom' => $searchNom,
            'formation' => $formation,
            'session' => $session,
            'user' => $user,
            'totalSession' => $totalSession,
            'totalPlaces' => $totalPlaces,
            'totalformation' => $totalformation,
            'sessions_today' => $sessionsToday
        ]);
    } 

    #[Route('/Quiz', name: 'app_quiz')]
    public function quiz(Request $request, QuizRepository $quizRepository): Response
    {
        $search = $request->query->get('search', '');
    
        if (!empty($search)) {
            $quizzes = $quizRepository->findByTitle($search);
        } else {
            $quizzes = $quizRepository->findAll();
        }
    
        return $this->render('quiz/index.html.twig', [
            'quizzes' => $quizzes,
        ]);
        $quizzes = $this->entityManager->getRepository(Quiz::class)->findAll();
        return $this->render('dashboard/Dahquiz.html.twig', [
            'quizzes' => $quizzes,
        ]);
    }
}
