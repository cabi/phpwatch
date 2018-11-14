<?php

declare(strict_types=1);

namespace PhpWatch\Database\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181114000000 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $schema->renameTable('log', 'logs');
        $schema->renameTable('user', 'users');
        $schema->renameTable('page', 'pages');

        $logs = $schema->getTable('logs');
        $logs->addColumn('page', Type::INTEGER);
        $logs->addForeignKeyConstraint('pages', ['page'], ['uid'], [], 'fk_log_page');

        $users = $schema->getTable('users');
        $users->dropColumn('username');
        $users->addColumn('email', Type::STRING);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $logs = $schema->getTable('users');
        $logs->dropColumn('email');
        $logs->addColumn('username', Type::STRING);

        $logs = $schema->getTable('logs');
        $logs->removeForeignKey('fk_log_page');
        $logs->dropColumn('page');

        $schema->renameTable('logs', 'log');
        $schema->renameTable('users', 'user');
        $schema->renameTable('pages', 'page');
    }
}
