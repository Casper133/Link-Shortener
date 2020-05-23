<?php

namespace LinkShortener;

use LinkShortener\Repository\DatabaseLinkRepository;
use function LinkShortener\Utils\authorizeUser;

require_once '../vendor/autoload.php';

$linkId = $_GET['id'];

if (isset($linkId)) {
    $user = authorizeUser();

    if ($user === null) {
        header('Location: sign_in.php');
        return;
    }

    $linkRepository = DatabaseLinkRepository::getInstance();

    $link = $linkRepository->getById($linkId);

    if ($link === null) {
        header('Location: links.php');
        return;
    }

    if ($link->getUserId() !== $user->getId()) {
        header('Location: main.php');
        return;
    }

    $linkRepository->delete($linkId);
    header('Location: links.php');
}
