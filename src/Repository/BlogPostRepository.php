<?php

namespace Gornung\Webentwicklung\Repository;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
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
     * @return \Gornung\Webentwicklung\Model\BlogPost|null
     */
    public function getByUrlKey(string $urlKey): ?BlogPost
    {
        try {
            $result = $this->getEntityManager()
                           ->createQueryBuilder()
                           ->select(
                               'post'
                           )
                           ->from(
                               'Gornung\Webentwicklung\Model\BlogPost',
                               'post'
                           )
                           ->where('post.urlKey like ?1')
                           ->setParameter(1, $urlKey)
                           ->getQuery()->getSingleResult();
        } catch (NoResultException | NonUniqueResultException $e) {
            return null;
        }
        return $result;
    }

    /**
     * @param  string  $keyword
     *
     * @return BlogPost[]
     */
    public function getByKeyword(string $keyword): array
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
     * @return object|BlogPost
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
    public function getEntityClassName(): string
    {
        return BlogPost::class;
    }
}
