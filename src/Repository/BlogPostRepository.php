<?php

namespace Gornung\Webentwicklung\Repository;

use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Gornung\Webentwicklung\Model\BlogPost;

class BlogPostRepository extends AbstractRepository
{

    /**
     * @return BlogPost[]
     */
    public function get(): array
    {
        return $this->getRepository()->findAll();
    }


    /**
     * @param  string  $urlKey
     *
     * @return \Gornung\Webentwicklung\Model\BlogPost
     */
    public function getByUrlKey(string $urlKey): BlogPost
    {
        $entityManager = $this->entityManager;
        $queryBuilder  = $entityManager->getQueryBuilder();

        $query = $queryBuilder->select('post', 'user')
                              ->from(
                                  'Gornung\Webentwicklung\Model',
                                  'post'
                              )
                              ->leftJoin('p.urlKey = :urlKey')
                              ->setParameter('urlKey', $urlKey)
                              ->getQuery();
        try {
            $blogPost = $query->getSingleResult();
            return $blogPost;
        } catch (Exception $e) {
            throw new DatabaseException();
        }
    }

    /**
     * @param  string  $keyword
     *
     * @return BlogPost[]
     */
    public function getByKeyword(string $keyword)
    {
        $dql   = " 
        SELECT b.title, b.text, b.author
          FROM Gornung\Webentwicklung\Model\BlogPost b
          WHERE b.author like '%$keyword%' or b.title like '%$keyword%' or b.text like '%$keyword%' 
    ";
        $query = $this->entityManager->createQuery($dql);

        return $query->getResult();
    }

    /**
     * @param  BlogPost  $blogPost
     *
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(BlogPost $blogPost): void
    {
        $this->getEntityManager()->persist($blogPost);
        $this->getEntityManager()->flush();
    }

    /**
     * @param  string  $id
     */
    public function removeById(string $id): void
    {
        $blogpost = $this->getById($id);

        try {
            $this->remove($blogpost);
        } catch (ORMException $e) {
            echo 'ORMException';
        }
    }

    /**
     * @param  string  $id
     *
     * @return BlogPost
     */
    public function getById(string $id): BlogPost
    {
        return $this->getRepository()->find($id);
    }

    /**
     * @param  BlogPost  $blogPost
     *
     * @return void
     * @throws ORMException
     */
    public function remove(BlogPost $blogPost): void
    {
        $this->getEntityManager()->remove($blogPost);
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
