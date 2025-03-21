<?php

declare(strict_types=1);

namespace App\Client;

use App\Client\Exception\ClientException;
use App\DTO\PostDTO;
use App\DTO\UserDTO;
use Symfony\Component\HttpFoundation\Request;
use InvalidArgumentException;

class Client
{
    public function __construct(private readonly HttpClient $httpClient)
    {
    }

    public function getUserList(): array
    {
        try {
            $response = $this->httpClient->sendRequest(
                Request::METHOD_GET,
                'users'
            );

            return UserDTO::fromArray($this->getData($response->getContent()));
        } catch (ClientException $e) {
            throw new ClientException($e->getMessage());
        }
    }

    public function getUserDetail(int $id): UserDTO
    {
        try {
            $response = $this->httpClient->sendRequest(
                Request::METHOD_GET,
                sprintf('users/%d', $id)
            );

            if ($response->getStatusCode() === 404) {
                throw new InvalidArgumentException('Nie udało się pobrać szczegółów użytkownika.');
            }

            return UserDTO::from($this->getData($response->getContent()));
        } catch (ClientException $e) {
            throw new ClientException($e->getMessage());
        }
    }

    public function getUserPosts(int $id): array
    {
        try {
            $response = $this->httpClient->sendRequest(
                Request::METHOD_GET,
                sprintf('users/%d/posts', $id)
            );

            if ($response->getStatusCode() === 404) {
                throw new ClientException('Nie udało się pobrać szczegółów użytkownika.');
            }

            return PostDTO::fromArray($this->getData($response->getContent()));
        } catch (ClientException $e) {
            throw new ClientException($e->getMessage());
        }
    }

    public function getPost(int $id): PostDTO
    {
        try {
            $response = $this->httpClient->sendRequest(
                Request::METHOD_GET,
                sprintf('posts/%d', $id)
            );

            if ($response->getStatusCode() === 404) {
                throw new InvalidArgumentException('Nie udało się pobrać szczegółów wpisu.');
            }

            return PostDTO::from($this->getData($response->getContent()));
        } catch (ClientException $e) {
            throw new ClientException($e->getMessage());
        }
    }

    public function editPost(int $id, PostDTO $dto): void
    {
        try {
            $response = $this->httpClient->sendRequest(
                Request::METHOD_PUT,
                sprintf('posts/%d', $id),
                $dto->toArray(),
            );

            if ($response->getStatusCode() === 422) {
                throw new InvalidArgumentException('Wprowadzono nieprawidłowe dane.');
            }
        } catch (ClientException $e) {
            throw new ClientException($e->getMessage());
        }
    }

    private function getData(string $json): array
    {
        return json_decode($json, true);
    }
}
