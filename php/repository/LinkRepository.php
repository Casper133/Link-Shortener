<?php

namespace LinkShortener\Repository;

use LinkShortener\Entity\Link;

interface LinkRepository
{
    public function getById(int $id): ?Link;

    public function getByShortLink(string $shortLink): ?Link;

    public function getAll(): array;

    public function getUserLinks(int $userId): array;

    public function save(Link $link): void;

    public function delete(int $id): void;
}
