<?php

namespace LinkShortener\Repository;

use LinkShortener\Entity\LoginCookie;

interface LoginCookieRepository
{
    public function getByValue(string $cookieValue): ?LoginCookie;

    public function save(LoginCookie $loginCookie): void;

    public function delete($id): void;
}
