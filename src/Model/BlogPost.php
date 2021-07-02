<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Model;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class BlogPost
 * @package Gornung\Webentwicklung
 *
 * @ORM\Entity
 * @ORM\Table(name="blog_post")
 */
class BlogPost
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
     * @ORM\Column(type="string", nullable=false)
     */
    protected $urlKey;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $text;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $author;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $dateTime;

    /**
     * BlogPost constructor.
     *
     * @param  string  $title
     * @param  string  $text
     * @param  string  $author
     * @param  string  $urlKey
     */
    public function __construct(
        string $title,
        string $text,
        string $author,
        string $urlKey
    ) {
        $time = new DateTime();
        //        $this->id  = generateID();
        $this->title    = $title;
        $this->text     = $text;
        $this->author   = $author;
        $this->urlKey   = $urlKey;
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
    public function getUrlKey(): string
    {
        return $this->urlKey;
    }

    /**
     * @param  string  $urlKey
     */
    public function setUrlKey(string $urlKey): void
    {
        $this->id = $urlKey;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param  string  $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param  string  $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param  string  $author
     */
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }
}
