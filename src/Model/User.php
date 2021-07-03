<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Model;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 *
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
{

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    protected int $dateTime;

    /**
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

    public function __construct($username, $password, $email)
    {
        $time = new DateTime();

        $this->username = $username;
        $this->password = $password;
        $this->email    = $email;
        $this->isAdmin  = false;
        $this->dateTime = $time->getTimestamp();
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
    public function setEmail(string $email): void
    {
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
    public function setIsAdmin(bool $isAdmin): void
    {
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
    public function setUsername(string $username): void
    {
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
    public function setPassword(string $password): void
    {
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
    public function setDateTime(int $dateTime): void
    {
        $this->dateTime = $dateTime;
    }
}
