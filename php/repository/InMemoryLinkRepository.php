<?php

namespace LinkShortener\Repository;

use LinkShortener\Entity\Link;

class InMemoryLinkRepository implements LinkRepository
{
    private static ?LinkRepository $instance = null;

    private int $idCounter = 0;
    private array $links = array();

    private function __construct() {}

    /**
     * @return LinkRepository
     */
    public static function getInstance(): LinkRepository
    {
        if (self::$instance === null) {
            self::$instance = new InMemoryLinkRepository();
        }

        return self::$instance;
    }

    /**
     * @param int $id
     * @return Link|null
     */
    public function getById(int $id): ?Link
    {
        if ($id < 0) {
            return null;
        }

        foreach ($this->links as $link) {
            if ($link->getId() === $id) {
                return $link;
            }
        }

        return null;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->links;
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

        $link->setId($this->idCounter);
        $this->idCounter++;
        $this->links[] = $link;
    }

    /**
     * @param Link $newLink
     */
    private function update(Link $newLink): void
    {
        $id = $newLink->getId();

        if ($id === null || $id < 0) {
            return;
        }

        $link = $this->getById($id);

        if ($link === null) {
            return;
        }

        $link->setOriginalLink($newLink->getOriginalLink());
        $link->setShortLink($newLink->getShortLink());
    }

    /**
     * @param int $id
     */
    public function delete(int $id): void
    {
        if ($id < 0) {
            return;
        }

        foreach ($this->links as $key => $link) {
            if ($link->getId() !== $id) {
                continue;
            }

            unset($this->links[$key]);
            array_values($this->links);
            return;
        }
    }
}
