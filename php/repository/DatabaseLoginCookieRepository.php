<?php

namespace LinkShortener\Repository;

use LinkShortener\Entity\LoginCookie;
use LinkShortener\Repository\Connection\PostgresPdoConnector;

class DatabaseLoginCookieRepository implements LoginCookieRepository
{
    private static ?LoginCookieRepository $instance = null;

    private PostgresPdoConnector $postgresPdoConnector;

    private function __construct()
    {
        $this->postgresPdoConnector = PostgresPdoConnector::getInstance();
    }

    private function __clone()
    {
    }

    /**
     * @return LoginCookieRepository
     */
    public static function getInstance(): LoginCookieRepository
    {
        if (self::$instance === null) {
            self::$instance = new DatabaseLoginCookieRepository();
        }

        return self::$instance;
    }

    /**
     * @param string $cookieValue
     * @return LoginCookie|null
     */
    public function getByValue(string $cookieValue): ?LoginCookie
    {
        if (empty($cookieValue)) {
            return null;
        }

        $sql = 'SELECT * FROM login_cookies WHERE value = ? LIMIT 1';
        $resultRow = $this->postgresPdoConnector->execute($sql, [$cookieValue])->fetch();

        if (empty($resultRow)) {
            return null;
        }

        return $this->mapRowToLoginCookie($resultRow);
    }


    private function mapRowToLoginCookie(array $row): LoginCookie
    {
        $loginCookie = new LoginCookie();
        $loginCookie->setId($row['id']);
        $loginCookie->setValue($row['value']);
        $loginCookie->setUserId($row['user_id']);

        return $loginCookie;
    }

    /**
     * @param LoginCookie $loginCookie
     */
    public function save(LoginCookie $loginCookie): void
    {
        if ($loginCookie->getId() !== null) {
            return;
        }

        $sql = 'INSERT INTO login_cookies(value, user_id) VALUES (?, ?)';
        $value = $loginCookie->getValue();
        $userId = $loginCookie->getUserId();

        $this->postgresPdoConnector->execute(
            $sql, [$value, $userId]
        );
    }

    /**
     * @param $id
     */
    public function delete($id): void
    {
        if ($id < 1) {
            return;
        }

        $sql = 'DELETE FROM login_cookies WHERE id = ?';
        $this->postgresPdoConnector->execute($sql, [$id]);
    }
}
