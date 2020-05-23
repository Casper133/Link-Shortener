<?php

namespace LinkShortener;

use LinkShortener\Entity\User;
use LinkShortener\Loader\TemplateLoader;
use LinkShortener\Repository\DatabaseUserRepository;
use function LinkShortener\Utils\authenticateUser;

require_once '../vendor/autoload.php';

$email = trim($_POST['email']);
$password = trim($_POST['password']);

if (!empty($email) && !empty($password)) {
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $user = new User();
    $user->setEmail($email);
    $user->setPassword($hashedPassword);

    $userRepository = DatabaseUserRepository::getInstance();
    $userRepository->save($user);

    $authenticatedUser = authenticateUser($email, $password);

    if ($authenticatedUser === null) {
        header('Location: sign_in.php');
        return;
    }

    header('Location: main.php');
    return;
}

$templateLoader = new TemplateLoader();
$templateLoader->loadTemplate('sign_up_page.twig');
