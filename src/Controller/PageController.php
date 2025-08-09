<?php

namespace App\Controller;

use App\Entity\Snippet;
use App\Repository\SnippetRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
        Request $request,
        SnippetRepository $snippetRepository
    ): Response
    {
        $snippets = $snippetRepository->getSnippets();
        $snippets->setMaxPerPage(3);
        $snippets->setCurrentPage($request->query->getInt('page', 1));

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

    #[Route('/item/{slug}', name: 'item')]
    public function item(
        #[MapEntity(mapping: ['slug' => 'slug'])]
        Snippet $snippet
    ): Response
    {
        return $this->render('pages/item.html.twig', [
            'title' => $snippet->getTitle(),
            'snippet' => $snippet
        ]);
    }
}