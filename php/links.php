<?php

namespace LinkShortener;

use LinkShortener\Loader\TemplateLoader;
use LinkShortener\Repository\DatabaseLinkRepository;
use function LinkShortener\Utils\authorizeUser;

require_once '../vendor/autoload.php';

$user = authorizeUser();

if ($user === null) {
    header('Location: sign_in.php');
    return;
}

$linkRepository = DatabaseLinkRepository::getInstance();
$userLinks = $linkRepository->getUserLinks($user->getId());
$pageContext = array('links' => $userLinks, 'isUserAuthorized' => true);

$templateLoader = new TemplateLoader();
$templateLoader->loadTemplate('links_page.twig', $pageContext);
