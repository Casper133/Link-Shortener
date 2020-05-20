<?php

namespace LinkShortener;

use LinkShortener\Repository\DatabaseLinkRepository;

require_once '../vendor/autoload.php';

$shortLink = explode('/l/', getenv('REQUEST_URI'))[1];
$linkRepository = DatabaseLinkRepository::getInstance();
$link = $linkRepository->getByShortLink($shortLink);

if ($link === null) {
    header('Location: /main.php');
    return;
}

$originalLink = $link->getOriginalLink();
header("Location: $originalLink");
