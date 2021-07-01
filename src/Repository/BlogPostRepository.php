<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Repository;

use Gornung\Webentwicklung\Model\BlogPost;
use PDO;

class BlogPostRepository extends AbstractRepository
{

    /**
     * BlogPostRepository constructor.
     */
    public function __construct()
    {
        $this->connectToDb();
    }


    /**
     * @param BlogPost $blogPost
     */
    public function add(BlogPost $blogPost): void
    {
        $query = $this->connection->prepare(
            'insert into blog_posts (title, url_key, author, text) values (:title, :urlKey, :author, :text); '
        );
        $query->bindParam(':title', $blogPost->title);
        $query->bindParam(':urlKey', $blogPost->urlKey);
        $query->bindParam(':author', $blogPost->author);
        $query->bindParam(':text', $blogPost->text);
        $query->execute();
    }


    /**
     * @param string $urlKey
     * @return BlogPost|null
     */
    public function getByUrlKey(string $urlKey): ?BlogPost
    {
        $query = $this->connection->prepare(
            'select * from blog_posts where url_key = :urlKey'
        );
        $query->bindParam(':urlKey', $urlKey);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $resultData = $query->fetch();

        if (!$resultData) {
            return null;
        }

        $result         = new BlogPost();
        $result->id     = $resultData['id'];
        $result->title  = $resultData['title'];
        $result->urlKey = $resultData['url_key'];
        $result->author = $resultData['author'];
        $result->text   = $resultData['text'];
        return $result;
    }
}
