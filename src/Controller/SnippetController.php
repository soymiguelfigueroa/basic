<?php

namespace App\Controller;

use App\Entity\Snippet;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class SnippetController extends AbstractController
{
    #[Route('/snippet/new', name: 'app_snippet_new', methods: ['GET', 'POST'])]
    public function newSnippet(
        #[CurrentUser] User $user,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        Request $request
    ): Response
    {
        $formData = $request->request;

        if ($request->isMethod('POST')) {
            $snippet = (new Snippet())
                ->setAuthor($user)
                ->setTitle($formData->get('title'))
                ->setDescription($formData->get('description'))
                ->setCode($formData->get('code'));

            $errors = $validator->validate($snippet);

            if (!$errors->count()) {
                $entityManager->persist($snippet);
                $entityManager->flush();

                return $this->redirectToRoute('item', ['slug' => $snippet->getSlug()]);
            }
        }

        return $this->render('snippet/new.html.twig', [
            'errors' => $errors ?? [],
            'data' => $formData->all(),
        ]);
    }

    #[Route('/snippet/{id}/fork', name: 'app_snippet_fork', methods: ['POST'])]
    public function forkSnippet(
        #[CurrentUser] User $user,
        EntityManagerInterface $entityManager,
        Snippet $snippet
    ): Response
    {
        $fork = (new Snippet())
            ->setAuthor($user)
            ->setTitle($snippet->getTitle() . ' (Fork)')
            ->setDescription($snippet->getDescription())
            ->setCode($snippet->getCode())
            ->setParent($snippet);

        $entityManager->persist($fork);
        $entityManager->flush();

        return $this->redirectToRoute('item', ['slug' => $fork->getSlug()]);
    }
}
