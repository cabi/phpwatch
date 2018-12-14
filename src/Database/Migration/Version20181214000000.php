<?php

/**
 * Version20181214000000.
 */

declare(strict_types=1);

namespace PhpWatch\Database\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Version20181214000000.
 */
final class Version20181214000000 extends AbstractMigration
{
    /**
     * Up.
     *
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function up(Schema $schema): void
    {
        $log = $schema->createTable('automatics');
        $log->addColumn('id', 'integer', ['autoincrement' => true]);
        $log->addColumn('nextRun', 'datetime');
        $log->addColumn('expression', 'string');
        $log->addColumn('lockRun', 'boolean');
        $log->addColumn('implementation', 'string');
        $log->setPrimaryKey(['id']);
    }

    /**
     * Down.
     *
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function down(Schema $schema): void
    {
        $schema->dropTable('automatics');
    }
}
