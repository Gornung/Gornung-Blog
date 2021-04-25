<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="blog_users")
 */
class BlogUser
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="string")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false, unique=true)
     */
    protected $username;
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $password;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $isAdmin;


    public function __construct()
    {
        $this->isAdmin = 0;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setPassword(string $password): void
    {
        if ($password != null) {
            $this->password = $password;
        }
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function isAdmin()
    {
        if ($this->isAdmin == 1) {
            return true;
        }
        return false;
    }

    public function setAdminRole(bool $value)
    {
        if ($value) {
            $this->isAdmin = 1;
        } else {
            $this->isAdmin = 0;
        }
    }

    public function getAdminRole()
    {
        return $this->isAdmin;
    }
}
