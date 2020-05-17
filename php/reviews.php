<?php

namespace LinkShortener;

use LinkShortener\Entity\Review;
use LinkShortener\Loader\TemplateLoader;
use LinkShortener\Repository\DatabaseReviewRepository;

require_once '../vendor/autoload.php';

$username = trim($_POST['username']);
$message = trim($_POST['message']);

if (!empty($username) && !empty($message)) {
    $message = replaceLinks($message);
    $reviewRepository = DatabaseReviewRepository::getInstance();

    $review = new Review();
    $review->setUsername($username);
    $review->setMessage($message);
    $reviewRepository->save($review);
}

loadReviewsTemplate();

function replaceLinks(string $message): string
{
    $pattern = '/(https?:\/\/(?!bsuir\.by)(?:[\w]*\.)(?!bsuir\.by)[\w.-\/]*)/';
    $replacement = '#External links not allowed#';
    $result = preg_replace($pattern, $replacement, $message);

    return $result ?? $message;
}

function loadReviewsTemplate()
{
    $reviewRepository = DatabaseReviewRepository::getInstance();
    $reviews = array('reviews' => $reviewRepository->getAll());

    $templateLoader = new TemplateLoader();
    $templateLoader->loadTemplateWithContext('reviews_page.twig', $reviews);
}
