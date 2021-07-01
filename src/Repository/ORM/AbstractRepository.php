<?php
//
//declare(strict_types=1);
//
//namespace Gornung\Webentwicklung\Repository;
//
//use Doctrine\ORM\EntityManager;
//use Doctrine\ORM\ORMException;
//use Doctrine\ORM\Tools\SchemaTool;
//use Doctrine\ORM\Tools\Setup;
//use Dotenv\Dotenv;
//use Gornung\Webentwicklung\Exceptions\DatabaseException;
//use PDOException;
//
//abstract class AbstractRepository
//{
//
//    protected EntityManager $entityManager;
//
//    /**
//     * AbstractRepository constructor.
//     *
//     * @throws \Doctrine\ORM\ORMException
//     * @throws \Gornung\Webentwicklung\Exceptions\DatabaseException
//     */
//    public function __construct()
//    {
//        try {
//            $this->createEntityManager();
//        } catch (ORMException $e) {
//            throw new ORMException($e->__toString());
//        } catch (DatabaseException $e) {
//            throw new DatabaseException('could not create an Entity Manager');
//        }
//    }
//
//    /**
//     * Create Doctrine's Entity Manager
//     *
//     * @throws DatabaseException|\Doctrine\ORM\ORMException
//     */
//    private function createEntityManager()
//    {
//        $dotenv = Dotenv::createImmutable(dirname(dirname(__DIR__)));
//        $dotenv->load();
//
//        try {
//            $isDevMode                 = true;
//            $proxyDir                  = null;
//            $cache                     = null;
//            $useSimpleAnnotationReader = false;
//            $config                    = Setup::createAnnotationMetadataConfiguration(
//                [__DIR__."/../Model"],
//                $isDevMode,
//                $proxyDir,
//                $cache,
//                $useSimpleAnnotationReader
//            );
//
//
//            $connectionParams = [
//              'dbname'   => $_ENV['DB_NAME'],
//              'user'     => $_ENV['DB_USER'],
//              'password' => $_ENV['DB_PASSWORD'],
//              'host'     => $_ENV['DB_HOST'],
//              'driver'   => $_ENV['DB_DRIVER'],
//            ];
//
//            $this->entityManager = EntityManager::create(
//                $connectionParams,
//                $config
//            );
//
//            // createSchema for first time before there is no db setted up TODO use it conditionaly
//            $this->createSchema();
//        } catch (PDOException $e) {
//            throw new DatabaseException(
//                'Failed to connect to Database with EntityManager',
//                400
//            );
//        }
//    }
//
//    /**
//     * @throws \Doctrine\ORM\Tools\ToolsException
//     */
//    private function createSchema()
//    {
//        $schemaTool = new SchemaTool($this->entityManager);
//        $schemaTool->createSchema(
//            [
//            $this->entityManager->getClassMetadata(
//                'Gornung\Webentwicklung\Model\BlogUser'
//            ),
//            $this->entityManager->getClassMetadata(
//                'Gornung\Webentwicklung\Model\BlogPost'
//            ),
//            ]
//        );
//    }
//
//    /**
//     * @return EntityManager
//     */
//    protected function getEntityManager(): EntityManager
//    {
//        return $this->entityManager;
//    }
//}
