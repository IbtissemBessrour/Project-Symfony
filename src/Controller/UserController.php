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
     public function checkLogin(Request $request ,UserRepository $userRepository) : Response
     {
         $email = $request->request->get('email');
         $password = $request->request->get('password');
         // Rechercher l'utilisateur par email
         $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
 
         if ($user && $user->getMotDePasse() === $password) {
            if($user && $user->getType() === 'etudian'){
                // Stocker l'information de connexion dans la session
             $session = $request->getSession();
             $session->set('user_id', $user->getId());
 
             // Rediriger vers la page d'accueil
             return $this->redirectToRoute('app_Etudient');
            }elseif($user && $user->getType() === 'formateur'){
                // Stocker l'information de connexion dans la session
             $session = $request->getSession();
             $session->set('user_id', $user->getId());
 
             // Rediriger vers la page d'accueil
             return $this->redirectToRoute('app_Fourmateur');
            }else{
                
                // Stocker l'information de connexion dans la session
             $session = $request->getSession();
             $session->set('user_id', $user->getId());
 
             // Rediriger vers la page d'accueil
             return $this->redirectToRoute('app_Admin');
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
    

}
