<?php

declare(strict_types=1);

namespace App\DTO;

class PostDTO
{
    public function __construct(
        public int $id,
        public int $userId,
        public string $title,
        public string $content,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            userId: $data['user_id'],
            title: $data['title'],
            content: $data['body'],
        );
    }

    public static function fromArray(array $data): array
    {
        $results = [];

        foreach ($data as $post) {
            $results[] = self::from($post);
        }

        return $results;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'title' => $this->title,
            'body' => $this->content,
        ];
    }
}
