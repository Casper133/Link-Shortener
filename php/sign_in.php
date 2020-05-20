<?php

namespace LinkShortener;

use LinkShortener\Loader\TemplateLoader;
use LinkShortener\Repository\DatabaseUserRepository;

require_once '../vendor/autoload.php';

$email = trim($_POST['email']);
$password = trim($_POST['password']);

if (!empty($email) && !empty($password)) {
    $userRepository = DatabaseUserRepository::getInstance();
    $user = $userRepository->getByEmail($email);

    if (password_verify($password, $user->getPassword())) {
        header('Location: main.php');
        return;
    }

    header('Location: sign_in.php');
    return;
}

$templateLoader = new TemplateLoader();
$templateLoader->loadTemplate('sign_in_page.twig');
