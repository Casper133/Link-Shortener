<?php

namespace LinkShortener;

use LinkShortener\Repository\DatabaseLinkRepository;

require_once '../vendor/autoload.php';

$linkId = $_GET['id'];

if (isset($linkId)) {
    $linkRepository = DatabaseLinkRepository::getInstance();
    $linkRepository->delete($linkId);
    header('Location: links.php');
}
