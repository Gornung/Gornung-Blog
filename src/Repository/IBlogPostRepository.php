<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Repository;

use Gornung\Webentwicklung\Model\BlogPost;

interface IBlogPostRepository
{

    /**
     * @param   \Gornung\Webentwicklung\Model\BlogPost  $post
     */
    public function add(BlogPost $post): void;

    /**
     * @param $id
     *
     * @return object
     */
    public function getById($id): object;

    /**
     * @param $keyword
     *
     * @return array
     */
    public function getByKeyword($keyword): array;

    /**
     * @return array
     */
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
