<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('pages/index.html.twig', [
            'title' => 'Home Page',
        ]);
    }

    #[Route('/about', name: 'about')]
    public function about(): Response
    {
        return $this->render('pages/about.html.twig', [
            'title' => 'About Us'
        ]);
    }

    #[Route('/item', name: 'item')]
    public function item(): Response
    {
        return $this->render('pages/item.html.twig', [
            'title' => 'Item Page',
        ]);
    }
}