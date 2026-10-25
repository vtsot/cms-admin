<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261026090000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Default sender for site settings';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            /** @lang MySQL */ '
            ALTER TABLE `site_settings`
                ADD `reply_to_email` VARCHAR(255) DEFAULT NULL
            '
        );
        $this->addSql(
            /** @lang MySQL */ '
            UPDATE `site_settings`
            SET
                `sender_name`  = \'Robot\',
                `sender_email` = \'robot@example.com\'
            WHERE `sender_email` IS NULL
            '
        );
        $this->addSql(
            /** @lang MySQL */ '
            UPDATE `pages`
            SET
                `sitemap_priority`         = 0.8,
                `sitemap_change_frequency` = \'daily\'
            WHERE `homepage` = 1
            '
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
            /** @lang MySQL */ '
            UPDATE `pages`
            SET
                `sitemap_priority`         = 0.5,
                `sitemap_change_frequency` = \'weekly\'
            WHERE `homepage` = 1
            '
        );
        $this->addSql(
            /** @lang MySQL */ '
            UPDATE `site_settings`
            SET
                `sender_name`  = NULL,
                `sender_email` = NULL
            WHERE `sender_email` = \'robot@example.com\'
            '
        );
        $this->addSql(
            /** @lang MySQL */ '
            ALTER TABLE `site_settings`
                DROP `reply_to_email`
            '
        );
    }
}
