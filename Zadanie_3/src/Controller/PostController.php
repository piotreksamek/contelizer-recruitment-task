<?php

declare(strict_types=1);

namespace App\Controller;

use App\Client\Client;
use App\Client\Exception\ClientException;
use App\Form\PostFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

#[Route(name: 'contelizer_user_',)]
class PostController extends AbstractController
{
    #[Route('/user/{id}/posts', name: 'posts', methods: [Request::METHOD_GET])]
    public function posts(int $id, Client $client): Response
    {
        try {
            $postsDTO = $client->getUserPosts($id);
        } catch (ClientException $e) {
            $this->addFlash('danger', $e->getMessage());

            return $this->redirectToRoute('contelizer_user_list');
        }

        return $this->render('user/post/list.html.twig', [
            'posts' => $postsDTO,
        ]);
    }

    #[Route('/user/{userId}/posts/{id}', name: 'posts_edit', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function editPost(
        int $userId,
        int $id,
        Request $request,
        Client $client
    ): Response {
        try {
            $postDTO = $client->getPost($id);
        } catch (ClientException $exception) {
            $this->addFlash('danger', $exception->getMessage());

            return $this->redirectToRoute('contelizer_user_list');
        }

        $form = $this->createForm(PostFormType::class, $postDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $client->editPost($id, $postDTO);

                $this->addFlash('success', 'Wpis został zaktualizowany.');
            } catch (Exception $e) {
                $this->addFlash('danger', $e->getMessage());

                return $this->redirectToRoute('contelizer_user_posts_edit', [
                    'userId' => $userId,
                    'id' => $id
                ]);
            }
        }

        return $this->render('user/post/edit.html.twig', [
            'form' => $form->createView(),
            'posts' => $postDTO,
            'userId' => $userId,
        ]);
    }
}
