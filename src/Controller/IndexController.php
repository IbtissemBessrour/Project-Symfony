<?php

namespace App\Controller;

use App\Entity\Bibliotheque;
use App\Entity\Evenement;
use App\Entity\Session;
use App\Entity\Formation;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

    }

    #[Route('/Admin', name: 'app_Admin')]

    public function Admin(): Response
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();
        $bibliotheque = $this->entityManager->getRepository(Bibliotheque::class)->findAll();
        return $this->render('dashboard/adminDa.html.twig', [
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

}
