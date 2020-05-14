<?php


namespace LinkShortener\Entity;

class Comment
{
    private string $username;
    private string $message;

    /**
     * Comment constructor.
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
}
