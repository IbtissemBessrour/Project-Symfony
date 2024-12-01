<?php

namespace App\Controller;

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

}
