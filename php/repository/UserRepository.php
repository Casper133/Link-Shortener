<?php

namespace LinkShortener\Repository;

use LinkShortener\Entity\User;

interface UserRepository
{
    public function getByEmail(string $email): ?User;

    public function save(User $user): void;
}
