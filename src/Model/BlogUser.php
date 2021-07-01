<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Model;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * Class User
 *
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class BlogUser
{

    /**
     * @var string
     * @ORM\Column(type = "string")
     * @ORM\Id
     */
    private string $userId;

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

    /**
     * @param $username
     * @param $password
     *
     */
    public function __construct($username, $password)
    {
        $this->userId   = Uuid::uuid4()->__toString();
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @param  string  $userId
     */
    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
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
}
