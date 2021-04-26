<?php

namespace Gornung\Webentwicklung\Repository;

use Gornung\Webentwicklung\Controller\Blog;
use Gornung\Webentwicklung\Model\BlogPost;

class BlogPostRepository extends AbstractRepository implements BlogPostRepoInterface
{

    public function save(BlogPost $post): void
    {
        // TODO: Implement save() method.
    }

    public function get(): array
    {
        // TODO: Implement get() method.
    }

    public function delete(BlogPost $post): void
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param $id
     *
     * @return object[]
     */
    public function getById($id): array
    {
        return $this->getRepository()->findAll($id);
    }

    /**
     * @param $id
     */
    public function deleteById($id): void
    {
        return $this->getRepository()->findAll();
    }

    /**
     * @return string
     */
    protected function getEntityClassName()
    {
        return BlogPost::class;
    }

}
