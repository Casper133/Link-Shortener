<?php

namespace LinkShortener;

use LinkShortener\Entity\User;
use LinkShortener\Loader\TemplateLoader;
use LinkShortener\Repository\DatabaseUserRepository;
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
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $user = new User();
    $user->setUsername($username);
    $user->setPassword($hashedPassword);

    $userRepository = DatabaseUserRepository::getInstance();
    $userRepository->save($user);

    $authenticatedUser = authenticateUser($username, $password);

    if ($authenticatedUser === null) {
        header('Location: sign_in.php');
        return;
    }

    header('Location: main.php');
    return;
}

$templateLoader = new TemplateLoader();
$templateLoader->loadTemplate('sign_up_page.twig', ['isUserAuthorized' => false]);
