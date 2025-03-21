<?php

declare(strict_types=1);

namespace App\Client;

use App\Client\Exception\ClientException;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class HttpClient
{
    public function __construct(
        private readonly string $url,
        private readonly string $apiKey,
        private readonly HttpClientInterface $client,
    ) {
    }

    public function sendRequest(string $method, string $prefix, array $body = []): ResponseInterface
    {
        try {
            return $this->client->request($method,
                sprintf('%s%s', $this->url, $prefix), [
                    'headers' => $this->getHeaders(),
                    'json' => $body,
                ]
            );
        } catch (TransportExceptionInterface $e) {
            throw new ClientException($e->getMessage());
        }
    }

    private function getHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => sprintf('Bearer %s', $this->apiKey),
        ];
    }
}
