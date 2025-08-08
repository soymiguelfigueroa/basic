<?php

namespace App\Controller;

use App\Repository\SnippetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
        SnippetRepository $snippetRepository
    ): Response
    {
        $snippets = $snippetRepository->findAll();

        return $this->render('pages/index.html.twig', [
            'title' => 'Home Page',
            'snippets' => $snippets
        ]);
    }

    #[Route('/about', name: 'about')]
    public function about(): Response
    {
        return $this->render('pages/about.html.twig', [
            'title' => 'About Us'
        ]);
    }

    #[Route('/item/{id}', name: 'item')]
    public function item(
        int $id,
        SnippetRepository $snippetRepository
    ): Response
    {
        $snippet = $snippetRepository->find($id);

        if (!$snippet) {
            throw $this->createNotFoundException('Snippet not found');
        }
        
        return $this->render('pages/item.html.twig', [
            'title' => $snippet->getTitle(),
            'snippet' => $snippet
        ]);
    }
}