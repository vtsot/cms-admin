<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20261102015338 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
        /** @lang MySQL */ '
        CREATE TABLE `user_clients` (
            `user_id` BINARY(16) NOT NULL,
            `site_id` BINARY(16) NOT NULL,

            INDEX `IDX_58C5307EA76ED395` (`user_id`),
            INDEX `IDX_58C5307EF6BD1646` (`site_id`),
            PRIMARY KEY                  (`user_id`, `site_id`)

        ) DEFAULT CHARACTER SET utf8mb4
        '
        );

        $this->addSql(
        /** @lang MySQL */ '
        ALTER TABLE `user_clients`
            ADD CONSTRAINT `FK_58C5307EA76ED395`
                FOREIGN KEY (`user_id`)
                REFERENCES `users` (`id`)
                ON DELETE CASCADE
        '
        );

        $this->addSql(
        /** @lang MySQL */ '
        ALTER TABLE `user_clients`
            ADD CONSTRAINT `FK_58C5307EF6BD1646`
                FOREIGN KEY (`site_id`)
                REFERENCES `sites` (`id`)
                ON DELETE CASCADE
        '
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
        /** @lang MySQL */ '
        ALTER TABLE `user_clients`
            DROP FOREIGN KEY `FK_58C5307EA76ED395`
        '
        );

        $this->addSql(
        /** @lang MySQL */ '
        ALTER TABLE `user_clients`
            DROP FOREIGN KEY `FK_58C5307EF6BD1646`
        '
        );

        $this->addSql(
        /** @lang MySQL */ '
        DROP TABLE `user_clients`
        '
        );
    }
}
