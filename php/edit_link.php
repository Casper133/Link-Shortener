<?php

namespace LinkShortener;

use LinkShortener\Loader\TemplateLoader;
use LinkShortener\Repository\InMemoryLinkRepository;

require_once '../vendor/autoload.php';

$linkId = $_GET['id'];
$newOriginalLink = $_POST['new_original_link'];

if (isset($linkId) && empty($newOriginalLink)) {
    $linkRepository = InMemoryLinkRepository::getInstance();
    $link = $linkRepository->getById($linkId);
    $originalLink = $link !== null ? $link->getOriginalLink() : '';

    $pageContext = array('originalLink' => $originalLink);

    $templateLoader = new TemplateLoader();
    $templateLoader->loadTemplateWithContext('edit_link_page.twig', $pageContext);
}

if (isset($linkId) && !empty($newOriginalLink)) {
    // TODO: update record in database
    header("Location: links.php");
}
