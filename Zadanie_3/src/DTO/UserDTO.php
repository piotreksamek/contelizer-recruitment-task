<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enum\Gender;
use App\Enum\Status;

readonly class UserDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public Gender $gender,
        public Status $status,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            email: $data['email'],
            gender: Gender::tryFrom($data['gender']),
            status: Status::tryFrom($data['status']),
        );
    }

    public static function fromArray(array $data): array
    {
        $results = [];

        foreach($data as $user) {
            $results[] = self::from($user);
        }

        return $results;
    }
}
