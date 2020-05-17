<?php

namespace LinkShortener\Repository\Connection;

use PDO;
use PDOStatement;

class PostgresPdoConnector
{
    private static ?PostgresPdoConnector $instance = null;

    private ?PDO $pdo = null;

    private function __construct()
    {
        $this->openConnection();
    }

    private function __clone()
    {
    }

    /**
     * @return PostgresPdoConnector
     */
    public static function getInstance(): PostgresPdoConnector
    {
        if (self::$instance === null) {
            self::$instance = new PostgresPdoConnector();
        }

        if (self::$instance->pdo === null) {
            self::$instance->openConnection();
        }

        return self::$instance;
    }

    private function openConnection(): void
    {
        $dbHost = getenv('POSTGRES_DB_HOST');
        $dbPort = getenv('POSTGRES_DB_PORT');
        $dbName = getenv('POSTGRES_DB_NAME');

        $dsn = "pgsql:host=$dbHost;port=$dbPort;dbname=$dbName";

        $pgUsername = getenv('POSTGRES_USERNAME');
        $pgPassword = getenv('POSTGRES_PASSWORD');

        $this->pdo = new PDO($dsn, $pgUsername, $pgPassword);
    }

    /**
     * @param string $sql
     * @param array $args
     * @return PDOStatement
     */
    public function execute(string $sql, array $args = []): PDOStatement
    {
        if (empty($args)) {
            return $this->pdo->query($sql);
        }

        $statement = $this->pdo->prepare($sql);
        $statement->execute($args);

        return $statement;
    }
}
