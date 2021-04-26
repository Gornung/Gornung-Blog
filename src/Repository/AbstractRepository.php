<?php

declare(strict_types=1);

namespace Gornung\Webentwicklung\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;
use Doctrine\Persistence\ObjectRepository;

abstract class AbstractRepository
{

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * AbstractRepository constructor.
     *
     * @throws ORMException
     */
    public function __construct()
    {
        $this->initEntityManager();
    }

    /**
     * @return void
     *
     * @throws ORMException
     */
    protected function initEntityManager()
    {
        // Create a simple "default" Doctrine ORM configuration for Annotations
        $config = Setup::createAnnotationMetadataConfiguration(
            [dirname(__DIR__) . '/Model'],
            (bool)getenv('APP_DEV_MODE'),
            null,
            null,
            false
        );

        // database configuration parameters
        $connectionDetails = [
          'driver' => 'pdo_mysql',
          'user' => getenv('DB_USER'),
          'password' => getenv('DB_PASSWORD'),
          'dbname' => getenv('DB_NAME'),
        ];

        // obtaining the entity manager
        $this->entityManager = EntityManager::create(
            $connectionDetails,
            $config
        );
    }

    /**
     * @return ObjectRepository
     */
    protected function getRepository()
    {
        return $this->getEntityManager()->getRepository(
            $this->getEntityClassName()
        );
    }

    /**
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @return string
     */
    abstract protected function getEntityClassName();
}
