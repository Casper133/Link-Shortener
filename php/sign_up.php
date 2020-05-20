<?php

namespace LinkShortener;

use LinkShortener\Entity\User;
use LinkShortener\Loader\TemplateLoader;
use LinkShortener\Repository\DatabaseUserRepository;

require_once '../vendor/autoload.php';

$email = trim($_POST['email']);
$password = trim($_POST['password']);

if (!empty($email) && !empty($password)) {
    $password = password_hash($password, PASSWORD_BCRYPT);

    $user = new User();
    $user->setEmail($email);
    $user->setPassword($password);

    $userRepository = DatabaseUserRepository::getInstance();
    $userRepository->save($user);

    header('Location: main.php');
    return;
}

$templateLoader = new TemplateLoader();
$templateLoader->loadTemplate('sign_up_page.twig');
