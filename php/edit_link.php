<?php

namespace LinkShortener;

use LinkShortener\Loader\TemplateLoader;
use LinkShortener\Repository\DatabaseLinkRepository;

require_once '../vendor/autoload.php';

$linkId = $_GET['id'];
$newOriginalLink = $_POST['new_original_link'];

$linkRepository = DatabaseLinkRepository::getInstance();

if (isset($linkId) && empty($newOriginalLink)) {
    $link = $linkRepository->getById($linkId);
    $originalLink = $link !== null ? $link->getOriginalLink() : '';

    $pageContext = array('originalLink' => $originalLink);

    $templateLoader = new TemplateLoader();
    $templateLoader->loadTemplate('edit_link_page.twig', $pageContext);
}

if (isset($linkId) && !empty($newOriginalLink)) {
    $link = $linkRepository->getById($linkId);
    $link->setOriginalLink($newOriginalLink);
    $linkRepository->save($link);
    header("Location: links.php");
}
