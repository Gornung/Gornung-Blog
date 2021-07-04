<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;
use Dotenv\Dotenv;
use Gornung\Webentwicklung\Exceptions\DatabaseException;
use PDOException;

abstract class AbstractRepository
{

    protected EntityManager $entityManager;

    /**
     * AbstractRepository constructor.
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Gornung\Webentwicklung\Exceptions\DatabaseException
     */
    public function __construct()
    {
        try {
            $this->createEntityManager();
        } catch (ORMException $e) {
            throw new ORMException($e->__toString());
        } catch (DatabaseException $e) {
            throw new DatabaseException('could not create an Entity Manager');
        }
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Gornung\Webentwicklung\Exceptions\DatabaseException
     */
    private function createEntityManager(): void
    {
        $dotenv = Dotenv::createImmutable(dirname(dirname(__DIR__)));
        $dotenv->load();

        try {
            $isDevMode                 = true;
            $proxyDir                  = null;
            $cache                     = null;
            $useSimpleAnnotationReader = false;
            $config                    = Setup::createAnnotationMetadataConfiguration(
                [dirname(__DIR__) . "/Model"],
                $isDevMode,
                $proxyDir,
                $cache,
                $useSimpleAnnotationReader
            );


            $connectionParams = [
              'dbname'   => $_ENV['DB_NAME'],
              'user'     => $_ENV['DB_USER'],
              'password' => $_ENV['DB_PASSWORD'],
              'host'     => $_ENV['DB_HOST'],
              'port'     => $_ENV['DB_PORT'],
              'driver'   => $_ENV['DB_DRIVER'],
            ];

            $this->entityManager = EntityManager::create(
                $connectionParams,
                $config
            );

            // createSchema for first time, to create tables
            // TODO use it conditionally
//                      $this->createSchema();
        } catch (PDOException $e) {
            throw new DatabaseException(
                'Failed to connect to Database with EntityManager',
                400
            );
        }
    }

    /**
     * @return EntityManager
     */
    protected function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

    /**
     * @throws \Doctrine\ORM\Tools\ToolsException
     */
    private function createSchema(): void
    {

        $schemaTool = new SchemaTool($this->entityManager);
        $schemaTool->createSchema(
            [
            $this->entityManager->getClassMetadata(
                'Gornung\Webentwicklung\Model\User'
            ),
            $this->entityManager->getClassMetadata(
                'Gornung\Webentwicklung\Model\BlogPost'
            ),
            ]
        );
    }

    /**
     * @return object
     */
    protected function getRepository(): object
    {
        /**
         * @psalm-suppress ArgumentTypeCoercion
         */
        return $this->getEntityManager()->getRepository(
            $this->getEntityClassName()
        );
    }

    /**
     * @return string
     */
    abstract public function getEntityClassName(): string;
}
