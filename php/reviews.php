<?php

namespace LinkShortener;

use LinkShortener\Entity\Review;
use LinkShortener\Loader\TemplateLoader;
use LinkShortener\Repository\JsonFileReviewRepository;

require_once '../vendor/autoload.php';

$username = trim($_POST['username']);
$message = trim($_POST['message']);

if (empty($username) && empty($message)) {
    loadReviewsTemplate();
}

if (!empty($username) && !empty($message)) {
    $review = new Review($username, $message);
    $reviewRepository = JsonFileReviewRepository::getInstance();
    $reviewRepository->save($review);

    loadReviewsTemplate();
}

function loadReviewsTemplate()
{
    $reviewRepository = JsonFileReviewRepository::getInstance();
    $reviews = array('reviews' => $reviewRepository->getAll());

    $templateLoader = new TemplateLoader();
    $templateLoader->loadTemplateWithContext('reviews_page.twig', $reviews);
}
