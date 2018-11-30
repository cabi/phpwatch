<?php

/**
 * DatabaseManager.
 */
declare(strict_types=1);

namespace PhpWatch\Database;

/**
 * DatabaseManager.
 */
class DatabaseManager
{
    /**
     * Manager.
     *
     * @var \Doctrine\DBAL\Connection
     */
    protected $connection;

    /**
     * Instance.
     *
     * @var null
     */
    protected static $instance = null;

    /**
     * Database constructor.
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function __construct()
    {
        $config = new \Doctrine\DBAL\Configuration();
        $this->connection = \Doctrine\DBAL\DriverManager::getConnection($this->getConnectionParams(), $config);
    }

    /**
     * Get connection.
     *
     * @return \Doctrine\DBAL\Connection
     */
    public function getConnection(): \Doctrine\DBAL\Connection
    {
        return $this->connection;
    }

    /**
     * Get Query object.
     *
     * @throws \Doctrine\DBAL\DBALException
     *
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    public static function getQuery(): \Doctrine\DBAL\Query\QueryBuilder
    {
        return self::getInstance()->getConnection()->createQueryBuilder();
    }

    /**
     * Get connection params.
     *
     * @return array
     */
    public function getConnectionParams(): array
    {
        return [
            'dbname' => 'sqlite3',
            'path' => APPLICATION_ROOT . 'data/data.sqlite',
            'driver' => 'pdo_sqlite',
        ];
    }

    /**
     * Build database.
     *
     * @throws \Doctrine\DBAL\DBALException
     *
     * @return DatabaseManager
     */
    public static function getInstance(): self
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
