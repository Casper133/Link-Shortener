<?php

namespace LinkShortener;

use LinkShortener\Loader\TemplateLoader;
use function LinkShortener\Utils\authenticateUser;
use function LinkShortener\Utils\authorizeUser;

require_once '../vendor/autoload.php';

$user = authorizeUser();

if ($user !== null) {
    header('Location: main.php');
    return;
}

$username = trim($_POST['username']);
$password = trim($_POST['password']);

if (!empty($username) && !empty($password)) {
    $user = authenticateUser($username, $password);

    if ($user === null) {
        header('Location: sign_in.php');
        return;
    }

    header('Location: main.php');
    return;
}

$templateLoader = new TemplateLoader();
$templateLoader->loadTemplate('sign_in_page.twig', ['isUserAuthorized' => false]);
