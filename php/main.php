<?php

namespace LinkShortener;

use Exception;
use LinkShortener\Entity\Link;
use LinkShortener\Loader\TemplateLoader;
use LinkShortener\Repository\DatabaseLinkRepository;

require_once '../vendor/autoload.php';

// TODO: Show navigation tabs depending on user's authorization
// TODO: set user id for new link if user authorized

$originalLink = trim($_POST['original_link']);

if (empty($originalLink)) {
    $templateLoader = new TemplateLoader();
    $templateLoader->loadTemplate('main_page.twig');
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

$link = new Link();
$link->setOriginalLink($originalLink);
$link->setShortLink($shortLink);

$linkRepository = DatabaseLinkRepository::getInstance();
$linkRepository->save($link);

header('Location: links.php');

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
