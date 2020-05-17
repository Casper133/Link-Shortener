<?php

namespace LinkShortener\Repository;

use LinkShortener\Entity\Review;
use LinkShortener\Repository\Connection\PostgresPdoConnector;

class DatabaseReviewRepository implements ReviewRepository
{
    private static ?ReviewRepository $instance = null;

    private PostgresPdoConnector $postgresPdoConnector;

    private function __construct()
    {
        $this->postgresPdoConnector = PostgresPdoConnector::getInstance();
    }

    private function __clone()
    {
    }

    /**
     * @return ReviewRepository
     */
    public static function getInstance(): ReviewRepository
    {
        if (self::$instance === null) {
            self::$instance = new DatabaseReviewRepository();
        }

        return self::$instance;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $sql = 'SELECT * FROM reviews ORDER BY id';
        $resultRows = $this->postgresPdoConnector->execute($sql)->fetchAll();

        $reviews = array();

        foreach ($resultRows as $row) {
            $reviews[] = $this->mapRowToReview($row);
        }

        return $reviews;
    }

    private function mapRowToReview(array $row): Review
    {
        $review = new Review();
        $review->setId($row['id']);
        $review->setUsername($row['username']);
        $review->setMessage($row['message']);

        return $review;
    }

    /**
     * @param Review $review
     */
    public function save(Review $review): void
    {
        if ($review->getId() !== null) {
            $this->update($review);
            return;
        }

        $sql = 'INSERT INTO reviews(username, message) VALUES (?, ?)';
        $username = $review->getUsername();
        $message = $review->getMessage();

        $this->postgresPdoConnector->execute(
            $sql, [$username, $message]
        );
    }

    private function update(Review $review): void
    {
        $id = $review->getId();

        if ($id < 1) {
            return;
        }

        $sql = 'UPDATE reviews SET username = ?, message = ? WHERE id = ?';
        $username = $review->getUsername();
        $message = $review->getMessage();

        $this->postgresPdoConnector->execute(
            $sql, [$username, $message]
        );
    }
}