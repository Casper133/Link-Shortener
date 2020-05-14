<?php

namespace LinkShortener;

use LinkShortener\Entity\Review;
use LinkShortener\Loader\TemplateLoader;
use LinkShortener\Repository\JsonFileReviewRepository;

require_once '../vendor/autoload.php';

$username = trim($_POST['username']);
$message = trim($_POST['message']);

if (!empty($username) && !empty($message)) {
    $message = replaceLinks($message);

    $review = new Review($username, $message);
    $reviewRepository = JsonFileReviewRepository::getInstance();
    $reviewRepository->save($review);

    loadReviewsTemplate();
} else {
    loadReviewsTemplate();
}

function replaceLinks(string $message): string
{
    $pattern = '/(https?:\/\/(?!bsuir\.by)(?:[\w]*\.)(?!bsuir\.by)[\w.-\/]*)/';
    $replacement = '#External links not allowed#';
    $result = preg_replace($pattern, $replacement, $message);

    return $result ?? $message;
}

function loadReviewsTemplate()
{
    $reviewRepository = JsonFileReviewRepository::getInstance();
    $reviews = array('reviews' => $reviewRepository->getAll());

    $templateLoader = new TemplateLoader();
    $templateLoader->loadTemplateWithContext('reviews_page.twig', $reviews);
}
