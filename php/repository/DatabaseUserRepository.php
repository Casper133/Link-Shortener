<?php

namespace LinkShortener\Repository;

use LinkShortener\Entity\User;
use LinkShortener\Repository\Connection\PostgresPdoConnector;

class DatabaseUserRepository implements UserRepository
{
    private static ?UserRepository $instance = null;

    private PostgresPdoConnector $postgresPdoConnector;

    private function __construct()
    {
        $this->postgresPdoConnector = PostgresPdoConnector::getInstance();
    }

    private function __clone()
    {
    }

    /**
     * @return UserRepository
     */
    public static function getInstance(): UserRepository
    {
        if (self::$instance === null) {
            self::$instance = new DatabaseUserRepository();
        }

        return self::$instance;
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function getById(int $id): ?User
    {
        if ($id < 1) {
            return null;
        }

        $sql = 'SELECT * FROM users WHERE id = ?';
        $resultRow = $this->postgresPdoConnector->execute($sql, [$id])->fetch();

        if (empty($resultRow)) {
            return null;
        }

        return $this->mapRowToUser($resultRow);
    }

    /**
     * @param string $username
     * @return User|null
     */
    public function getByUsername(string $username): ?User
    {
        $sql = 'SELECT * FROM users WHERE username = ? LIMIT 1';
        $resultRow = $this->postgresPdoConnector->execute($sql, [$username])->fetch();

        if (empty($resultRow)) {
            return null;
        }

        return $this->mapRowToUser($resultRow);
    }

    private function mapRowToUser(array $row): User
    {
        $user = new User();
        $user->setId($row['id']);
        $user->setUsername($row['username']);
        $user->setPassword($row['password']);

        return $user;
    }

    /**
     * @param User $user
     */
    public function save(User $user): void
    {
        if ($user->getId() !== null) {
            return;
        }

        $sql = 'INSERT INTO users(username, password) VALUES (?, ?)';
        $username = $user->getUsername();
        $password = $user->getPassword();

        $this->postgresPdoConnector->execute(
            $sql, [$username, $password]
        );
    }
}
