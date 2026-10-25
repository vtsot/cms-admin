<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261025101847 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Gedmo personal translations for navigations and banners';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            /** @lang MySQL */ '
            CREATE TABLE `banner_translations` (
                `id`        INT AUTO_INCREMENT NOT NULL,
                `locale`    VARCHAR(8) NOT NULL,
                `field`     VARCHAR(32) NOT NULL,
                `content`   LONGTEXT DEFAULT NULL,
                `object_id` BINARY(16) NOT NULL,
                UNIQUE INDEX `uniq_locale_object_field` (`locale`, `object_id`, `field`),
                INDEX `IDX_F8B8D8B232D562B` (`object_id`),
                PRIMARY KEY (`id`)
            ) DEFAULT CHARACTER SET utf8mb4
            '
        );
        $this->addSql(
            /** @lang MySQL */ '
            CREATE TABLE `navigation_translations` (
                `id`        INT AUTO_INCREMENT NOT NULL,
                `locale`    VARCHAR(8) NOT NULL,
                `field`     VARCHAR(32) NOT NULL,
                `content`   LONGTEXT DEFAULT NULL,
                `object_id` BINARY(16) NOT NULL,
                UNIQUE INDEX `uniq_locale_object_field` (`locale`, `object_id`, `field`),
                INDEX `IDX_DC8810C6232D562B` (`object_id`),
                PRIMARY KEY (`id`)
            ) DEFAULT CHARACTER SET utf8mb4
            '
        );
        $this->addSql(
            /** @lang MySQL */ '
            ALTER TABLE `banner_translations`
                ADD CONSTRAINT `FK_F8B8D8B232D562B` FOREIGN KEY (`object_id`) REFERENCES `site_banners` (`id`) ON DELETE CASCADE
            '
        );
        $this->addSql(
            /** @lang MySQL */ '
            ALTER TABLE `navigation_translations`
                ADD CONSTRAINT `FK_DC8810C6232D562B` FOREIGN KEY (`object_id`) REFERENCES `navigations` (`id`) ON DELETE CASCADE
            '
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(
            /** @lang MySQL */ '
            ALTER TABLE `banner_translations`
                DROP FOREIGN KEY `FK_F8B8D8B232D562B`
            '
        );
        $this->addSql(
            /** @lang MySQL */ '
            ALTER TABLE `navigation_translations`
                DROP FOREIGN KEY `FK_DC8810C6232D562B`
            '
        );
        $this->addSql(
            /** @lang MySQL */ '
            DROP TABLE `banner_translations`
            '
        );
        $this->addSql(
            /** @lang MySQL */ '
            DROP TABLE `navigation_translations`
            '
        );
    }
}
