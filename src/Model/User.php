<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Model;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use stdClass;

/**
 * Class User
 *
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User implements JsonSerializable
{

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    protected int $dateTime;

    /**
     * @psalm-suppress PropertyNotSetInConstructor
     *
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="string")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private string $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private string $email;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private bool $isAdmin;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private string $username;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private string $password;

    public function __construct(
        string $username,
        string $password,
        string $email
    ) {
        $time = new DateTime();

        $this->username = $username;
        $this->password = $password;
        $this->email    = $email;
        $this->isAdmin  = false;
        $this->dateTime = $time->getTimestamp();
    }

    /**
     * @return bool
     */
    public function getAdminStatus(): bool
    {
        return $this->isAdmin;
    }

    /**
     * @param  bool  $isAdmin
     *
     * @return bool
     */
    public function setAdminStatus(bool $isAdmin): bool
    {
        return $this->isAdmin = $isAdmin;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param  string  $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param  string  $email
     */
    public function setEmail(
        string $email
    ): void {
        $this->email = $email;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    /**
     * @param  bool  $isAdmin
     */
    public function setIsAdmin(
        bool $isAdmin
    ): void {
        $this->isAdmin = $isAdmin;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param  string  $username
     */
    public function setUsername(
        string $username
    ): void {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param  string  $password
     */
    public function setPassword(
        string $password
    ): void {
        $this->password = $password;
    }

    /**
     * @return int
     */
    public function getDateTime(): int
    {
        return $this->dateTime;
    }

    /**
     * @param  int  $dateTime
     */
    public function setDateTime(
        int $dateTime
    ): void {
        $this->dateTime = $dateTime;
    }

    /**
     * @return object
     */
    public function jsonSerialize()
    {
        $serializable                     = new stdClass();
        $serializable->registeredDateTime = $this->dateTime;
        $serializable->email              = $this->email;
        $serializable->username           = $this->username;
        $serializable->isAdmin            = $this->isAdmin;

        return $serializable;
    }
}
