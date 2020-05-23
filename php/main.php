<?php

namespace LinkShortener;

use Exception;
use LinkShortener\Entity\Link;
use LinkShortener\Entity\User;
use LinkShortener\Loader\TemplateLoader;
use LinkShortener\Repository\DatabaseLinkRepository;
use function LinkShortener\Utils\authorizeUser;

require_once '../vendor/autoload.php';

$originalLink = trim($_POST['original_link']);

if (empty($originalLink)) {
    $user = authorizeUser();
    $isUserAuthorizedArray = ['isUserAuthorized' => $user !== null];

    $templateLoader = new TemplateLoader();
    $templateLoader->loadTemplate('main_page.twig', $isUserAuthorizedArray);

    return;
}

try {
    $shortLink = generateShortLink(5);
} catch (Exception $exception) {
    echo $exception->getMessage();
    $shortLink = '';
}

if (empty($shortLink)) {
    return;
}

$user = authorizeUser();
$isUserAuthorized = $user !== null;

$link = fillLinkObject($originalLink, $shortLink, $user);

$linkRepository = DatabaseLinkRepository::getInstance();
$linkRepository->save($link);

if ($isUserAuthorized) {
    header('Location: links.php');
    return;
}

$shortLink = getenv('CURRENT_DOMAIN') . '/l/' . $shortLink;
$pageContext = array('shortLink' => $shortLink, 'isUserAuthorized' => false);

$templateLoader = new TemplateLoader();
$templateLoader->loadTemplate('main_page.twig', $pageContext);

/**
 * @param string $originalLink
 * @param string $shortLink
 * @param User|null $user
 * @return Link
 */
function fillLinkObject(string $originalLink, string $shortLink, ?User $user): Link
{
    $link = new Link();
    $link->setOriginalLink($originalLink);
    $link->setShortLink($shortLink);

    if ($user !== null) {
        $link->setUserId($user->getId());
    }

    return $link;
}

/**
 * @param int $resultLength
 * @return string
 * @throws Exception
 */
function generateShortLink($resultLength)
{
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charsLength = strlen($chars);
    $randomString = '';

    for ($i = 0; $i < $resultLength; $i++) {
        $randomCharacter = $chars[random_int(0, $charsLength - 1)];
        $randomString .= $randomCharacter;
    }

    return $randomString;
}
