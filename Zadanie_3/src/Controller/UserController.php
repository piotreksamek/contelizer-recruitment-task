<?php

declare(strict_types=1);

namespace App\Controller;

use App\Client\Client;
use App\Client\Exception\ClientException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

#[Route('/user', name: 'contelizer_user_',)]
class UserController extends AbstractController
{
    #[Route('/list', name: 'list', methods: [Request::METHOD_GET])]
    public function index(Client $client): Response
    {
        try {
            $usersDTO = $client->getUserList();
        } catch (ClientException $e) {
            $this->addFlash('danger', $e->getMessage());

            return $this->redirectToRoute('contelizer_user_list');
        }

        return $this->render('user/list.html.twig', [
            'users' => $usersDTO,
        ]);
    }

    #[Route('/search/{id}', name: 'search', methods: [Request::METHOD_GET])]
    public function searchUser(int $id, Client $client): JsonResponse
    {
        try {
            $userDTO = $client->getUserDetail($id);
        } catch (Exception $exception) {
            return new JsonResponse([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }

        return new JsonResponse([
            'status' => 'success',
            'data' => $userDTO,
        ]);
    }

    #[Route('/all', name: 'get_all', methods: [Request::METHOD_GET])]
    public function getAllUsers(Client $client): JsonResponse
    {
        try {
            $usersDTO = $client->getUserList();
        } catch (Exception $exception) {
            return new JsonResponse([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }

        return new JsonResponse([
            'status' => 'success',
            'data' => $usersDTO,
        ]);
    }
}
