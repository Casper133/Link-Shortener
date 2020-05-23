<?php

namespace LinkShortener;

use LinkShortener\Entity\Link;
use LinkShortener\Loader\TemplateLoader;
use LinkShortener\Repository\DatabaseLinkRepository;
use LinkShortener\Repository\LinkRepository;
use function LinkShortener\Utils\authorizeUser;

require_once '../vendor/autoload.php';

$linkId = $_GET['id'];
$newOriginalLink = trim($_POST['new_original_link']);

$linkRepository = DatabaseLinkRepository::getInstance();

if (isset($linkId) && empty($newOriginalLink)) {
    $link = checkLink($linkRepository, $linkId);

    if ($link === null) {
        return;
    }

    $originalLink = $link->getOriginalLink();
    $pageContext = array('originalLink' => $originalLink, 'isUserAuthorized' => true);

    $templateLoader = new TemplateLoader();
    $templateLoader->loadTemplate('edit_link_page.twig', $pageContext);
}

if (isset($linkId) && !empty($newOriginalLink)) {
    $link = checkLink($linkRepository, $linkId);

    if ($link === null) {
        return;
    }

    $link->setOriginalLink($newOriginalLink);
    $linkRepository->save($link);
    header('Location: links.php');
}

/**
 * @param LinkRepository $linkRepository
 * @param $linkId
 * @return Link|null
 */
function checkLink(LinkRepository $linkRepository, $linkId): ?Link
{
    $user = authorizeUser();

    if ($user === null) {
        header('Location: sign_in.php');
        return null;
    }

    $link = $linkRepository->getById($linkId);

    if ($link === null) {
        header('Location: links.php');
        return null;
    }

    if ($link->getUserId() !== $user->getId()) {
        header('Location: main.php');
        return null;
    }

    return $link;
}
