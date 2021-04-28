<?php

namespace Gornung\Webentwicklung\Repository;

use Doctrine\ORM\ORMException;
use Gornung\Webentwicklung\Model\BlogPost;

class BlogPostRepository extends AbstractRepository implements
    IBlogPostRepository
{

    /**
     * @return BlogPost[]
     */
    public function get(): array
    {
        return $this->getRepository()->findAll();
    }

    /**
     * @param $id
     */
    public function deleteById($id): void
    {
        $blogpost = $this->getById($id);

        try {
            $this->delete($blogpost);
        } catch (ORMException $e) {
            echo 'ORMException';
        }
    }

    /**
     * @param $id
     *
     * @return object
     */
    public function getById($id): object
    {
        return $this->getRepository()->find($id);
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    public function delete(BlogPost $post): void
    {
        $this->getEntityManager()->remove($post);
        $this->getEntityManager()->flush();
    }

    public function getByKeyword($keyword): array
    {
        $sql   = " 
          SELECT b.title, b.text, b.author
          FROM Gornung\Webentwicklung\Model\BlogPost b
          WHERE b.author like '%$keyword%' or b.title like '%$keyword%' or b.text like '%$keyword%' 
        ";
        $query = $this->entityManager->createQuery($sql);

        return $query->getResult();
    }

    /**
     * @param   \Gornung\Webentwicklung\Model\BlogPost  $post
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function add(BlogPost $post): void
    {
        $this->getEntityManager()->persist($post);
        $this->getEntityManager()->flush();
    }

    /**
     * @return string
     */
    protected function getEntityClassName(): string
    {
        return BlogPost::class;
    }
}
