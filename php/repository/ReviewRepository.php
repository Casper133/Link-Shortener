<?php


namespace LinkShortener\Repository;

use LinkShortener\Entity\Review;

interface ReviewRepository
{
    public function getAll(): array;

    public function save(Review $review): void;
}
