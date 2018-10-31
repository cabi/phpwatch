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
     */
    protected function __construct()
    {
        $config = new \Doctrine\DBAL\Configuration();
        $this->connection = \Doctrine\DBAL\DriverManager::getConnection($this->getConnectionParams(), $config);
    }

    /**
     * @return \Doctrine\DBAL\Connection
     */
    public function getConnection(): \Doctrine\DBAL\Connection
    {
        return $this->connection;
    }

    /**
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    public static function getQuery(): \Doctrine\DBAL\Query\QueryBuilder
    {
        return self::getInstance()->getConnection()->createQueryBuilder();
    }

    public function getConnectionParams(): array
    {
        // sqlite
        return [
            'dbname' => 'sqlite3',
            'path' => APPLICATION_ROOT . 'data/data.sqlite',
            'driver' => 'pdo_sqlite',
        ];
    }

    /**
     * Build database.
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
