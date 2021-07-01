<?php
//
//declare(strict_types=1);
//
//namespace Gornung\Webentwicklung\Model;
//
//use Doctrine\ORM\Mapping as ORM;
//
///**
// * Class BlogPost
// *
// * @package Gornung\Webentwicklung\Model
// *
// * @author  gornung
// * @ORM\Entity
// * @ORM\Table(name="blog_post)
// *
// */
//class BlogPost
//{
//
//    /**
//     * @var string
//     *
//     * @ORM\Id
//     * @ORM\Column(type="string")
//     * @ORM\GeneratedValue(strategy="UUID")
//     */
//    protected $id;
//
//    /**
//     * @var string
//     *
//     * @ORM\Column(type="string", nullable=false)
//     */
//    protected string $title;
//
//    /**
//     * @var string
//     *
//     * @ORM\Column(type="string", nullable=false)
//     */
//    protected string $text;
//
//    /**
//     * @var string
//     *
//     * @ORM\Column(type="string", nullable=false)
//     */
//    protected string $author;
//
//    /**
//     * @var string
//     *
//     * @ORM\Column(type="datetime", nullable=false)
//     */
//    protected string $dateTime;
//
//    /**
//     * @return string
//     */
//    public function getId(): string
//    {
//        return $this->id;
//    }
//
//    /**
//     * @param   string  $id
//     */
//    public function setId(string $id): void
//    {
//        $this->id = $id;
//    }
//
//    /**
//     * @return string
//     */
//    public function getTitle(): string
//    {
//        return $this->title;
//    }
//
//    /**
//     * @param   string  $title
//     */
//    public function setTitle(string $title): void
//    {
//        $this->title = $title;
//    }
//
//    /**
//     * @return string
//     */
//    public function getText(): string
//    {
//        return $this->text;
//    }
//
//    /**
//     * @param   string  $text
//     */
//    public function setText(string $text): void
//    {
//        $this->text = $text;
//    }
//
//    /**
//     * @return string
//     */
//    public function getAuthor(): string
//    {
//        return $this->author;
//    }
//
//    /**
//     * @param   string  $author
//     */
//    public function setAuthor(string $author): void
//    {
//        $this->author = $author;
//    }
//}
