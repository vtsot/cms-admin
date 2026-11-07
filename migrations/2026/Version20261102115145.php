<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20261102115145 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql(
        /** @lang MySQL */ '
        CREATE TABLE `refresh_tokens` (
            `refresh_token` VARCHAR(128) NOT NULL,
            `username`      VARCHAR(255) NOT NULL,
            `valid`         DATETIME(6) NOT NULL,
            `family`        VARCHAR(32) DEFAULT NULL,
            `family_valid`  DATETIME(6) DEFAULT NULL,
            `id`            INT AUTO_INCREMENT NOT NULL,

            UNIQUE INDEX `UNIQ_9BACE7E1C74F2195` (`refresh_token`),
            PRIMARY KEY                          (`id`)

        ) DEFAULT CHARACTER SET utf8mb4
        '
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
        /** @lang MySQL */ '
        DROP TABLE `refresh_tokens`
        '
        );
    }
}
