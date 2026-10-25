<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261022161055 extends AbstractMigration
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
            ALTER TABLE `pages`
                CHANGE `content` `content` TEXT DEFAULT NULL,
                CHANGE `code_block` `code_block` TEXT DEFAULT NULL,
                CHANGE `description` `description` TEXT DEFAULT NULL
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `site_settings`
                DROP `theme_primary_color`,
                DROP `theme_text_color`,
                DROP `theme_top_bg_color`,
                DROP `theme_footer_bg_color`
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `sites`
                DROP `archive_birth_year`,
                DROP `global_search_volume`,
                DROP `us_search_volume`,
                DROP `moz_spam`,
                DROP `ahrefs_domain_rating`,
                DROP `ahrefs_back_links`,
                DROP `ahrefs_ref_domains`,
                DROP `semrush_authority_score`,
                DROP `semrush_back_links`,
                DROP `semrush_ref_domains`,
                DROP `wikipedia_link`,
                DROP `is_penalty`
            '
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `pages`
                CHANGE `content` `content` LONGTEXT DEFAULT NULL,
                CHANGE `code_block` `code_block` LONGTEXT DEFAULT NULL,
                CHANGE `description` `description` LONGTEXT DEFAULT NULL
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `site_settings`
                ADD `theme_primary_color` VARCHAR(7) DEFAULT NULL,
                ADD `theme_text_color` VARCHAR(7) DEFAULT NULL,
                ADD `theme_top_bg_color` VARCHAR(7) DEFAULT NULL,
                ADD `theme_footer_bg_color` VARCHAR(7) DEFAULT NULL
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `sites`
                ADD `archive_birth_year` INT UNSIGNED DEFAULT NULL,
                ADD `global_search_volume` DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
                ADD `us_search_volume` DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
                ADD `moz_spam` DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
                ADD `ahrefs_domain_rating` DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
                ADD `ahrefs_back_links` DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
                ADD `ahrefs_ref_domains` DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
                ADD `semrush_authority_score` DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
                ADD `semrush_back_links` DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
                ADD `semrush_ref_domains` DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
                ADD `wikipedia_link` VARCHAR(255) DEFAULT NULL,
                ADD `is_penalty` TINYINT DEFAULT 0 NOT NULL
            '
        );
    }
}
