<?php

/**
 * Version20181019134912.
 */

declare(strict_types=1);

namespace PhpWatch\Database\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Version20181019134912.
 */
final class Version20181019134912 extends AbstractMigration
{
    /**
     * Up.
     *
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $user = $schema->createTable('user');
        $user->addColumn('id', 'integer', ['autoincrement' => true]);
        $user->addColumn('username', 'string');
        $user->addColumn('password', 'string');
        $user->setPrimaryKey(['id']);

        $log = $schema->createTable('log');
        $log->addColumn('id', 'integer', ['autoincrement' => true]);
        $log->addColumn('source', 'string');
        $log->addColumn('state', 'string');
        $log->setPrimaryKey(['id']);

        $log = $schema->createTable('page');
        $log->addColumn('id', 'integer', ['autoincrement' => true]);
        $log->addColumn('uri', 'string');
        $log->addColumn('apiKey', 'string');
        $log->setPrimaryKey(['id']);
    }

    /**
     * Down.
     *
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $schema->dropTable('users');
        $schema->dropTable('log');
        $schema->dropTable('page');
    }
}
