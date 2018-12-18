<?php

/**
 * Version20181217000000.
 */

declare(strict_types=1);

namespace PhpWatch\Database\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Version20181217000000.
 */
final class Version20181217000000 extends AbstractMigration
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
        $automatics = $schema->getTable('automatics');
        $automatics->addColumn('page', 'integer', ['notnull' => false]);
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
        $automatics = $schema->getTable('automatics');
        $automatics->dropColumn('page');
    }
}
