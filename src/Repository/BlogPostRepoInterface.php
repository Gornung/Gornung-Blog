<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Repository;

use Gornung\Webentwicklung\Model\BlogPost;

interface BlogPostRepoInterface
{

    /**
     * @param   \Gornung\Webentwicklung\Model\BlogPost  $post
     */
    public function save(BlogPost $post): void;

    /**
     * @param $id
     *
     * @return \Gornung\Webentwicklung\Model\BlogPost
     */
    public function getById($id): BlogPost;

    /**
     * @return array
    public function get(): array;

    /**
     * @param   \Gornung\Webentwicklung\Model\BlogPost  $post
     */
    public function delete(BlogPost $post): void;

    /**
     * @param $id
     */
    public function deleteById($id): void;
}
