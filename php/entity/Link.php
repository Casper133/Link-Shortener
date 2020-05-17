<?php

namespace LinkShortener\Entity;

class Link
{
    private ?int $id = null;
    private string $originalLink = '';
    private string $shortLink = '';
    private ?int $userId = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getOriginalLink(): string
    {
        return $this->originalLink;
    }

    /**
     * @param string $originalLink
     */
    public function setOriginalLink(string $originalLink): void
    {
        $this->originalLink = $originalLink;
    }

    /**
     * @return string
     */
    public function getShortLink(): string
    {
        return $this->shortLink;
    }

    /**
     * @param string $shortLink
     */
    public function setShortLink(string $shortLink): void
    {
        $this->shortLink = $shortLink;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }
}
