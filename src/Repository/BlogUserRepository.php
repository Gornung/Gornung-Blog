<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Repository;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\ORMException;
use Gornung\Webentwicklung\Model\User;

class BlogUserRepository extends AbstractRepository
{

    /**
     * @return User[]
     */
    public function get(): array
    {
        return $this->getRepository()->findAll();
    }

    /**
     * @param  User  $user
     *
     * @return void
     * @throws ORMException
     */
    public function add(User $user): void
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }


    /**
     * @param  \Gornung\Webentwicklung\Model\User  $user
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(User $user): void
    {
        $this->getRepository()->find($user->getId());
        $this->getEntityManager()->flush();
    }

    /**
     * @param  string  $username
     *
     * @return User|null
     */
    public function getByUsername(string $username): ?User
    {
        try {
            $result = $this->getEntityManager()
                           ->createQueryBuilder()
                           ->select('user')
                           ->from('Gornung\Webentwicklung\Model\User', 'user')
                           ->where('user.username like ?1')
                           ->setParameter(1, $username)
                           ->getQuery()
                           ->getSingleResult();
        } catch (NoResultException | NonUniqueResultException $e) {
            return null;
        }
        return $result;
    }

    /**
     * @return string
     */
    public function getEntityClassName(): string
    {
        return User::class;
    }
}
