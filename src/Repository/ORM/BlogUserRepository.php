<?php
//
//declare(strict_types=1);
//
//namespace Gornung\Webentwicklung\Repository;
//
//use Doctrine\ORM\ORMException;
//use Gornung\Webentwicklung\Model\BlogUser;
//
//class BlogUserRepository extends AbstractRepository
//{
//
//    /**
//     * @param  BlogUser  $BlogUser
//     *
//     * @return void
//     * @throws ORMException
//     */
//    public function add(BlogUser $BlogUser): void
//    {
//        $this->getEntityManager()->persist($BlogUser);
//        $this->getEntityManager()->flush();
//    }
//
//
//    /**
//     * @param  \Gornung\Webentwicklung\Model\BlogUser  $BlogUser
//     *
//     * @throws \Doctrine\ORM\ORMException
//     * @throws \Doctrine\ORM\OptimisticLockException
//     */
//    public function update(BlogUser $BlogUser): void
//    {
//        $this->getRepository()->find($BlogUser->getUserID());
//        $this->getEntityManager()->flush();
//    }
//
//    /**
//     * @param  string  $BlogUsername
//     *
//     * @return BlogUser
//     */
//    public function getByUsername(string $BlogUsername): ?BlogUser
//    {
//        $qb = $this->getEntityManager()->createQueryBuilder()
//                   ->select('user')
//                   ->from('Gornung\Webentwicklung\Models\BlogUser', 'user')
//                   ->where('user.username = ?1')
//                   ->setParameter(1, $BlogUsername);
//
//        $query = $qb->getQuery();
//
//        if ($query->getResult(Query::HYDRATE_OBJECT) != null) {
//            return $query->getResult(Query::HYDRATE_OBJECT)[0];
//        } else {
//            return null;
//        }
//    }
//
//    /**
//     * @return string
//     */
//    protected function getEntityClassName(): string
//    {
//        return BlogUser::class;
//    }
//
//    /**
//     * @param  string  $entityName
//     *
//     * @return mixed
//     */
//}
