<?php


namespace LinkShortener\Repository;


use JsonException;
use LinkShortener\Entity\Review;

class JsonFileReviewRepository implements ReviewRepository
{
    private static ?ReviewRepository $instance = null;
    private const FILE_NAME = '../vendor/reviews.json';

    private function __construct()
    {
        if (!file_exists(self::FILE_NAME)) {
            file_put_contents(self::FILE_NAME, '');
        }
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
            self::$instance = new JsonFileReviewRepository();
        }

        return self::$instance;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $fileContent = file_get_contents(self::FILE_NAME);

        if ($fileContent === false) {
            return array();
        }

        $reviews = null;

        try {
            $reviews = json_decode($fileContent, null, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            return array();
        }

        if ($reviews === null) {
            return array();
        }

        return $reviews;
    }

    /**
     * @param Review $review
     */
    public function save(Review $review): void
    {
        $reviews = $this->getAll();
        $reviews[] = $review;

        try {
            $jsonReviews = json_encode($reviews, JSON_THROW_ON_ERROR, 512);
            file_put_contents(self::FILE_NAME, $jsonReviews);
        } catch (JsonException $exception) {
            return;
        }
    }
}