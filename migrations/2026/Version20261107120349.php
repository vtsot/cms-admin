<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20261107120349 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql(/** @lang MySQL */'
        CREATE TABLE `site_contacts` (
            `id` BINARY(16) NOT NULL,
            `site_id` BINARY(16) DEFAULT NULL,
            `context` JSON DEFAULT NULL,
            `created_at` DATETIME(6) DEFAULT NULL,
            `updated_at` DATETIME(6) DEFAULT NULL,

            INDEX `fk_site_id` (`site_id`),
            INDEX `idx_created_at` (created_at),
            INDEX `idx_updated_at` (`updated_at`),

            UNIQUE INDEX `uniq_id` (`id`),
            PRIMARY KEY (`id`)
        ) DEFAULT CHARACTER SET `utf8mb4`
        ');

        $this->addSql(/** @lang MySQL */'
        ALTER TABLE `site_contacts`
            ADD CONSTRAINT `FK_B7C604F3F6BD1646`
                FOREIGN KEY (`site_id`)
                REFERENCES `sites` (`id`)
                ON DELETE CASCADE
        ');

        $this->addSql(/** @lang MySQL */'
        ALTER TABLE `pages`
            CHANGE `sitemap_change_frequency` `sitemap_change_frequency` VARCHAR(255) DEFAULT \'weekly\' NOT NULL
        ');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(/** @lang MySQL */'
        ALTER TABLE `site_contacts`
            DROP FOREIGN KEY `FK_B7C604F3F6BD1646`
        ');

        $this->addSql(/** @lang MySQL */'
        DROP TABLE `site_contacts`
        ');

        $this->addSql(/** @lang MySQL */'
        ALTER TABLE `pages`
            CHANGE `sitemap_change_frequency` `sitemap_change_frequency` VARCHAR(255) DEFAULT \'Weekly\' NOT NULL
        ');
    }
}
