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
     * @param string $email
     * @return User|null
     */
    public function getByEmail(string $email): ?User
    {
        $sql = 'SELECT * FROM users WHERE email = ? LIMIT 1';
        $resultRow = $this->postgresPdoConnector->execute($sql, [$email])->fetch();

        if (empty($resultRow)) {
            return null;
        }

        return $this->mapRowToUser($resultRow);
    }

    private function mapRowToUser(array $row): User
    {
        $user = new User();
        $user->setId($row['id']);
        $user->setEmail($row['email']);
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

        $sql = 'INSERT INTO users(email, password) VALUES (?, ?)';
        $email = $user->getEmail();
        $password = $user->getPassword();

        $this->postgresPdoConnector->execute(
            $sql, [$email, $password]
        );
    }
}
