<?php

namespace LinkShortener\Utils;

use LinkShortener\Entity\LoginCookie;
use LinkShortener\Entity\User;
use LinkShortener\Repository\DatabaseLoginCookieRepository;
use LinkShortener\Repository\DatabaseUserRepository;

const LOGIN_COOKIE_NAME = 'auth-cookie';

function authenticateUser(string $email, string $password): ?User
{
    $userRepository = DatabaseUserRepository::getInstance();
    $user = $userRepository->getByEmail($email);

    if ($user === null) {
        return null;
    }

    if (!password_verify($password, $user->getPassword())) {
        return null;
    }

    $loginCookieValue = sha1(
        time() . $_SERVER['REMOTE_ADDR'] . $user->getId() . $user->getEmail() . $user->getPassword()
    );

    $loginCookie = new LoginCookie();
    $loginCookie->setValue($loginCookieValue);
    $loginCookie->setUserId($user->getId());

    $loginCookieRepository = DatabaseLoginCookieRepository::getInstance();
    $loginCookieRepository->save($loginCookie);

    setcookie(
        LOGIN_COOKIE_NAME,
        $loginCookieValue,
        time() + 365 * 24 * 60 * 60
    );

    return $user;
}

function authorizeUser(): ?User
{
    $loginCookie = getLoginCookie();

    if ($loginCookie === null) {
        return null;
    }

    $userRepository = DatabaseUserRepository::getInstance();
    return $userRepository->getById($loginCookie->getUserId());
}

function logoutUser(): void
{
    $loginCookie = getLoginCookie();

    if ($loginCookie === null) {
        return;
    }

    $loginCookieRepository = DatabaseLoginCookieRepository::getInstance();
    $loginCookieRepository->delete($loginCookie->getId());
    setcookie(LOGIN_COOKIE_NAME, '');
}

function getLoginCookie(): ?LoginCookie
{
    $loginCookieValue = $_COOKIE[LOGIN_COOKIE_NAME];

    if (empty($loginCookieValue)) {
        return null;
    }

    $loginCookieRepository = DatabaseLoginCookieRepository::getInstance();
    return $loginCookieRepository->getByValue($loginCookieValue);
}
