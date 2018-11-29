<?php

declare(strict_types=1);

namespace PhpWatch\Database\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\Migrations\AbstractMigration;

final class Version20181128000000 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $users = $schema->getTable('logs');
        $users->dropColumn('state');
        $users->addColumn('level', Type::INTEGER);
        $users->addColumn('message', Type::STRING);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $users = $schema->getTable('logs');
        $users->dropColumn('level');
        $users->dropColumn('message');
        $users->addColumn('state', Type::STRING);
    }
}
