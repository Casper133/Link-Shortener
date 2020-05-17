<?php

namespace LinkShortener\Repository;

use LinkShortener\Entity\Link;
use LinkShortener\Repository\Connection\PostgresPdoConnector;

class DatabaseLinkRepository implements LinkRepository
{
    private static ?LinkRepository $instance = null;

    private PostgresPdoConnector $postgresPdoConnector;

    private function __construct()
    {
        $this->postgresPdoConnector = PostgresPdoConnector::getInstance();
    }

    private function __clone()
    {
    }

    /**
     * @return LinkRepository
     */
    public static function getInstance(): LinkRepository
    {
        if (self::$instance === null) {
            self::$instance = new DatabaseLinkRepository();
        }

        return self::$instance;
    }

    /**
     * @param int $id
     * @return Link|null
     */
    public function getById(int $id): ?Link
    {
        if ($id < 1) {
            return null;
        }

        $sql = 'SELECT * FROM links WHERE id = ?';
        $resultRow = $this->postgresPdoConnector->execute($sql, [$id])->fetch();

        return $this->mapRowToLink($resultRow);
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $sql = 'SELECT * FROM links ORDER BY id';
        $resultRows = $this->postgresPdoConnector->execute($sql)->fetchAll();

        $links = array();

        foreach ($resultRows as $row) {
            $links[] = $this->mapRowToLink($row);
        }

        return $links;
    }

    private function mapRowToLink(array $row): Link
    {
        $link = new Link();
        $link->setId($row['id']);
        $link->setOriginalLink($row['original_link']);
        $link->setShortLink($row['short_link']);
        $link->setUserId($row['user_id']);

        return $link;
    }

    /**
     * @param Link $link
     */
    public function save(Link $link): void
    {
        if ($link->getId() !== null) {
            $this->update($link);
            return;
        }

        $sql = 'INSERT INTO links(original_link, short_link, user_id) VALUES (?, ?, ?)';
        $originalLink = $link->getOriginalLink();
        $shortLink = $link->getShortLink();
        $userId = $link->getUserId();

        $this->postgresPdoConnector->execute(
            $sql, [$originalLink, $shortLink, $userId]
        );
    }

    private function update(Link $link): void
    {
        $id = $link->getId();

        if ($id < 1) {
            return;
        }

        $sql = 'UPDATE links SET original_link = ?, short_link = ?, user_id = ? WHERE id = ?';
        $originalLink = $link->getOriginalLink();
        $shortLink = $link->getShortLink();
        $userId = $link->getUserId();

        $this->postgresPdoConnector->execute(
            $sql, [$originalLink, $shortLink, $userId, $id]
        );
    }

    /**
     * @param int $id
     */
    public function delete(int $id): void
    {
        if ($id < 1) {
            return;
        }

        $sql = 'DELETE FROM links WHERE id = ?';
        $this->postgresPdoConnector->execute($sql, [$id]);
    }
}
