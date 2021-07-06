<?php

namespace Gornung\Webentwicklung\Repository;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\ORMException;
use Gornung\Webentwicklung\Model\BlogPost;

class BlogPostRepository extends AbstractRepository
{

    /**
     * @return BlogPost[]
     */
    public function get(): array
    {
        // TODO: return orderBy dateTime DESC
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
            return $this->getEntityManager()
                        ->createQueryBuilder()
                        ->select(
                            'post'
                        )
                        ->from(
                            'Gornung\Webentwicklung\Model\BlogPost',
                            'post'
                        )
                        ->where('post.urlKey like ?1')
              //        setParameter prevents SQL Injection
                        ->setParameter(1, $urlKey)
                        ->getQuery()->getSingleResult();
        } catch (NoResultException | NonUniqueResultException $e) {
            return null;
        }
    }


    /**
     * @param  string  $keyword
     *
     * @return array
     */
    public function getByKeyword(string $keyword): array
    {
        return $this->getEntityManager()
                    ->createQueryBuilder()
                    ->select(
                        'post'
                    )
                    ->from(
                        'Gornung\Webentwicklung\Model\BlogPost',
                        'post'
                    )
                    ->where(
                        'post.author like :keyword or post.text like :keyword or post.title like :keyword'
                    )
                    ->setParameter('keyword', '%' . $keyword . '%')
                    ->getQuery()
                    ->getResult();
    }

    /**
     * @param  BlogPost  $blogPost
     *
     * @return void
     * @throws \Doctrine\ORM\ORMException
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
            /**
             * @psalm-suppress ArgumentTypeCoercion
             */
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
     * @param  BlogPost  $post
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(BlogPost $post): void
    {
        $this->getRepository()->find($post->getId());
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
