<?php

namespace LinkShortener;

use LinkShortener\Loader\TemplateLoader;
use function LinkShortener\Utils\authenticateUser;

require_once '../vendor/autoload.php';

$email = trim($_POST['email']);
$password = trim($_POST['password']);

if (!empty($email) && !empty($password)) {
    $user = authenticateUser($email, $password);

    if ($user === null) {
        header('Location: sign_in.php');
        return;
    }

    header('Location: main.php');
    return;
}

$templateLoader = new TemplateLoader();
$templateLoader->loadTemplate('sign_in_page.twig');
