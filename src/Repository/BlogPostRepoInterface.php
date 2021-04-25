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
    public function get($id): BlogPost;

    /**
     * @param   \Gornung\Webentwicklung\  $collectionBuilder
     *
     * @return array
     */
    //    public function getList(BuilderInterface $collectionBuilder): array;

    /**
     * @param   \Gornung\Webentwicklung\Model\BlogPost  $post
     */
    public function delete(BlogPost $post): void;
}
