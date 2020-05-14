<?php


namespace LinkShortener\Entity;

use JsonSerializable;

class Review implements JsonSerializable
{
    private string $username;
    private string $message;

    /**
     * Review constructor.
     * @param string $username
     * @param string $message
     */
    public function __construct(string $username, string $message)
    {
        $this->username = $username;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function jsonSerialize()
    {
        return array(
            'username' => $this->username,
            'message' => $this->message
        );
    }
}
