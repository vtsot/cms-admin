<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261024174542 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            /** @lang MySQL */ '
            ALTER TABLE `navigations`
                CHANGE `position` `position` INT UNSIGNED DEFAULT 0 NOT NULL
            '
        );
        $this->addSql(
            /** @lang MySQL */ '
            ALTER TABLE `page_related_articles`
                CHANGE `position` `position` INT UNSIGNED DEFAULT 0 NOT NULL
            '
        );
        $this->addSql(
            /** @lang MySQL */ '
            ALTER TABLE `pages`
                CHANGE `sitemap_change_frequency` `sitemap_change_frequency` VARCHAR(255) DEFAULT \'Weekly\' NOT NULL
            '
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(
            /** @lang MySQL */ '
            ALTER TABLE `navigations`
                CHANGE `position` `position` INT DEFAULT 0 NOT NULL
            '
        );
        $this->addSql(
            /** @lang MySQL */ '
            ALTER TABLE `page_related_articles`
                CHANGE `position` `position` INT DEFAULT 0 NOT NULL
            '
        );
        $this->addSql(
            /** @lang MySQL */ '
            ALTER TABLE `pages`
                CHANGE `sitemap_change_frequency` `sitemap_change_frequency` VARCHAR(255) DEFAULT \'weekly\' NOT NULL
            '
        );
    }
}
