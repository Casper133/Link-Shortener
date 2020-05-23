<?php

namespace LinkShortener\Repository;

use LinkShortener\Entity\User;

interface UserRepository
{
    public function getById(int $id): ?User;

    public function getByUsername(string $username): ?User;

    public function save(User $user): void;
}
