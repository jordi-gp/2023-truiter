<?php

namespace App;
use DateTime;
use Serializable;


class User
{
    private string $name;
    private string $username;
    private DateTime $createdAt;
    private bool $verified;

    public function __construct(string $name, string $username)
    {
        $this->name = $name;
        $this->username = $username;
        $this->createdAt = new DateTime();
    }

    public function setId(int $id):void
    {
        $this->id = $id;
    }

    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return bool
     */
    public function isVerified(): bool
    {
        return $this->verified;
    }

    /**
     * @param bool $verified
     */
    public function setVerified(bool $verified): void
    {
        $this->verified = $verified;
    }
/*
    public function serialize()
    {
        return json_encode([$this->username, $this->name, $this->createdAt->format("Y-m-d")]);
    }

    public function unserialize(string $data)
    {
        // TODO: Implement unserialize() method.
        $array = json_decode($data);

        $this->username = $data[0];
        $this->name = $data[1];
        $this->createdAt = DateTime::createFromFormat("Y-m-d", $data[2]);

    }

    public function __serialize(): array
    {
        return [$this->username, $this->name, $this->createdAt->format("Y-m-d")];
    }

    public function __unserialize(array $data): void
    {
        $this->username = $data[0];
        $this->name = $data[1];
        $this->createdAt = DateTime::createFromFormat("Y-m-d", $data[2]);
    }*/
}
