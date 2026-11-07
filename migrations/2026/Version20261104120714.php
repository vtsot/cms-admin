<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20261104120714 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql(
        /** @lang MySQL */ '
        CREATE TABLE `logs` (
            `id`         BINARY(16) NOT NULL,
            `created_at` DATETIME(6) DEFAULT NULL,
            `updated_at` DATETIME(6) DEFAULT NULL,
            `message`    VARCHAR(255) DEFAULT NULL,
            `method`     VARCHAR(255) DEFAULT NULL,
            `url`        VARCHAR(255) DEFAULT NULL,
            `request`    TEXT DEFAULT NULL,
            `headers`    TEXT DEFAULT NULL,
            `response`   TEXT DEFAULT NULL,
            `content`    TEXT DEFAULT NULL,
            `payload`    TEXT DEFAULT NULL,
            `site_id`    BINARY(16) DEFAULT NULL,

            INDEX `fk_site_id`     (`site_id`),
            INDEX `idx_created_at` (`created_at`),
            INDEX `idx_updated_at` (`updated_at`),
            UNIQUE INDEX `uniq_id` (`id`),
            PRIMARY KEY            (`id`)

        ) DEFAULT CHARACTER SET utf8mb4
        '
        );

        $this->addSql(
        /** @lang MySQL */ '
        ALTER TABLE `logs`
            ADD CONSTRAINT `FK_F08FC65CF6BD1646`
                FOREIGN KEY (`site_id`)
                REFERENCES `sites` (`id`)
                ON DELETE CASCADE
        '
        );

        $this->addSql(
        /** @lang MySQL */ '
        ALTER TABLE `site_settings`
            ADD `api_log_enabled` TINYINT DEFAULT 0 NOT NULL,
            CHANGE `image_title` `image_alt` VARCHAR(255) DEFAULT NULL
        '
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
        /** @lang MySQL */ '
        ALTER TABLE `logs`
            DROP FOREIGN KEY `FK_F08FC65CF6BD1646`
        '
        );

        $this->addSql(
        /** @lang MySQL */ '
        DROP TABLE `logs`
        '
        );

        $this->addSql(
        /** @lang MySQL */ '
        ALTER TABLE `site_settings`
            DROP `api_log_enabled`,
            CHANGE `image_alt` `image_title` VARCHAR(255) DEFAULT NULL
        '
        );
    }
}
