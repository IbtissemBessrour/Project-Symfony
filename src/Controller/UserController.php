<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;



#[Route('/user')]
final class UserController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/login.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

   /* #[Route('/admin/audit', name: 'admin_audit')]
    public function indexlog(AuditLogRepository $auditLogRepository)
    {
        $logs = $auditLogRepository->findBy([], ['timestamp' => 'DESC']);

        return $this->render('admin/audit/index.html.twig', [
            'logs' => $logs,
        ]);
    }*/

   /* #[Route(name: 'app_user_index', methods: [ 'GET'])]
    public function dath(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }*/

    //UTILISE PAR DEFFAOUTL
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

    }


     //METHODE LOGIN
     #[Route('/login-check', name: 'app_login_check', methods: ['POST'])]
public function checkLogin(Request $request, UserRepository $userRepository): Response
{
    $email = $request->request->get('email');
    $password = $request->request->get('password');

    // Rechercher l'utilisateur par email
    $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

    if ($user && $user->getMotDePasse() === $password) {
        // Vérifier le type de l'utilisateur
        $session = $request->getSession();
        $session->set('user_id', $user->getId());

        if ($user->getType() === 'etudiant') {
            return $this->redirectToRoute('app_Etudient');
        } elseif ($user->getType() === 'formateur') {
            return $this->redirectToRoute('app_Fourmateur');
        } elseif ($user->getType() === 'admin') {
            return $this->redirectToRoute('app_Admin');
        } else {
            // Si le type n'est pas reconnu
            $this->addFlash('error', 'Type d\'utilisateur inconnu');
            return $this->redirectToRoute('app_enregistre');
        }
    } else {
        // Afficher un message d'erreur si les identifiants sont incorrects
        $this->addFlash('error', 'Email ou mot de passe incorrect');
        return $this->redirectToRoute('app_enregistre');
    }
}

   


    //METHODE ENREGISTRE
    
    #[Route('/enregistre', name: 'app_enregistre', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
      
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);


        }

          return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
            
        ]);
    }


   

    //METHODE AFFICHE
    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    //METHODE MODIFIE
    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET','POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_Admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    //METHODE SUPPRIME
    #[Route('/{id}', name: 'admin_user_delete', methods: ['POST'])]
    public function deleteUser(User $user): RedirectResponse
    {
        // Supprimer l'utilisateur
        $this->entityManager->remove($user);
        $this->entityManager->flush();//elle fait le commit dans la liste 

        // Ajouter un message flash pour la confirmation de suppression
        $this->addFlash('success', 'Utilisateur supprimé avec succès !');

        // Rediriger vers la liste des utilisateurs
        return $this->redirectToRoute('app_Admin');
    }

    //recherche---------

  /* #[Route('/Admin', name: 'app_Admin' , methods: ['GET'])]
    public function Session(UserRepository $UserRepository,  Request $request): Response
    {
         // Récupération des valeurs de recherche depuis la requête GET
 $searchNom = $request->query->get('searchNom', '');

 // Création de la requête pour récupérer les users
 $queryBuilder = $UserRepository->createQueryBuilder('u');

 // Appliquer les filtres de recherche
 if ($searchNom) {
     $queryBuilder->andWhere('u.nom LIKE :nom')
                  ->setParameter('nom', '%' . $searchNom . '%');
 }

 // Appliquer le tri
 $sort = $request->query->get('sort', 'prenom');
 $order = $request->query->get('order', 'ASC');
 $queryBuilder->orderBy('u.' . $sort, $order);

 // Récupérer les users filtrées
 $user = $queryBuilder->getQuery()->getResult();
        return $this->render('dashboard/adminDa.html.twig', [
            'searchNom' => $searchNom,
            'user' => $user,
        ]);
    }*/
    

}