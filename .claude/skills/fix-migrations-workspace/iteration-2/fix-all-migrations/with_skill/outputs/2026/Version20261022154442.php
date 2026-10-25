<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261022154442 extends AbstractMigration
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
            CREATE TABLE `navigations` (
                `id`              BINARY(16) NOT NULL,
                `created_at`      DATETIME(6) DEFAULT NULL,
                `updated_at`      DATETIME(6) DEFAULT NULL,
                `type`            VARCHAR(255) DEFAULT \'main\',
                `active`          TINYINT DEFAULT 1 NOT NULL,
                `title`           VARCHAR(255) DEFAULT NULL,
                `link_type`       VARCHAR(15) DEFAULT NULL,
                `link_url`        VARCHAR(255) DEFAULT NULL,
                `link_target`     VARCHAR(15) DEFAULT NULL,
                `link_no_follow`  TINYINT DEFAULT 0 NOT NULL,
                `position`        INT DEFAULT 0 NOT NULL,
                `parent_id`       BINARY(16) DEFAULT NULL,
                `site_id`         BINARY(16) DEFAULT NULL,
                `link_page_id`    BINARY(16) DEFAULT NULL,
                `link_article_id` BINARY(16) DEFAULT NULL,
                `entity`          VARCHAR(255) NOT NULL,

                INDEX `idx_parent_id` (`parent_id`),
                INDEX `fk_link_page` (`link_page_id`),
                INDEX `fk_link_article` (`link_article_id`),
                INDEX `idx_active` (`active`),
                INDEX `fk_site_id` (`site_id`),
                INDEX `idx_created_at` (`created_at`),
                INDEX `idx_updated_at` (`updated_at`),
                UNIQUE INDEX `uniq_id` (`id`),
                PRIMARY KEY (`id`)

            ) DEFAULT CHARACTER SET utf8mb4
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            CREATE TABLE `page_related_articles` (
                `id`         BINARY(16) NOT NULL,
                `created_at` DATETIME(6) DEFAULT NULL,
                `updated_at` DATETIME(6) DEFAULT NULL,
                `active`     TINYINT DEFAULT 1 NOT NULL,
                `position`   INT DEFAULT 0 NOT NULL,
                `page_id`    BINARY(16) DEFAULT NULL,
                `article_id` BINARY(16) DEFAULT NULL,

                INDEX `fk_page_id` (`page_id`),
                INDEX `fk_article_id` (`article_id`),
                INDEX `idx_active` (`active`),
                INDEX `idx_created_at` (`created_at`),
                INDEX `idx_updated_at` (`updated_at`),
                UNIQUE INDEX `uniq_id` (`id`),
                PRIMARY KEY (`id`)

            ) DEFAULT CHARACTER SET utf8mb4
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            CREATE TABLE `pages` (
                `id`                       BINARY(16) NOT NULL,
                `created_at`               DATETIME(6) DEFAULT NULL,
                `updated_at`               DATETIME(6) DEFAULT NULL,
                `homepage`                 TINYINT DEFAULT 0 NOT NULL,
                `active`                   TINYINT DEFAULT 1 NOT NULL,
                `title`                    VARCHAR(255) DEFAULT NULL,
                `content`                  LONGTEXT DEFAULT NULL,
                `slug`                     VARCHAR(255) DEFAULT NULL,
                `meta_title`               VARCHAR(255) DEFAULT NULL,
                `meta_keywords`            VARCHAR(1000) DEFAULT NULL,
                `meta_description`         VARCHAR(1000) DEFAULT NULL,
                `og_title`                 VARCHAR(255) DEFAULT NULL,
                `og_description`           LONGTEXT DEFAULT NULL,
                `og_image`                 LONGTEXT DEFAULT NULL,
                `is_indexed`               TINYINT DEFAULT 1 NOT NULL,
                `sitemap_change_frequency` VARCHAR(255) DEFAULT \'weekly\' NOT NULL,
                `sitemap_priority`         DOUBLE PRECISION DEFAULT 0.5 NOT NULL,
                `redirect`                 VARCHAR(255) DEFAULT NULL,
                `code_block`               LONGTEXT DEFAULT NULL,
                `sources`                  TEXT DEFAULT NULL,
                `site_id`                  BINARY(16) DEFAULT NULL,
                `entity`                   VARCHAR(255) NOT NULL,
                `related_articles_title`   VARCHAR(255) DEFAULT NULL,
                `image`                    VARCHAR(255) DEFAULT NULL,
                `alt`                      VARCHAR(255) DEFAULT NULL,
                `description`              LONGTEXT DEFAULT NULL,

                INDEX `fk_site_id` (`site_id`),
                INDEX `idx_active` (`active`),
                INDEX `idx_homepage` (`homepage`),
                INDEX `idx_created_at` (`created_at`),
                INDEX `idx_updated_at` (`updated_at`),
                UNIQUE INDEX `uniq_site_slug` (`slug`, `site_id`),
                UNIQUE INDEX `uniq_id` (`id`),
                PRIMARY KEY (`id`)

            ) DEFAULT CHARACTER SET utf8mb4
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            CREATE TABLE `site_banners` (
                `id`              BINARY(16) NOT NULL,
                `created_at`      DATETIME(6) DEFAULT NULL,
                `updated_at`      DATETIME(6) DEFAULT NULL,
                `desktop_image`   VARCHAR(255) DEFAULT NULL,
                `mobile_image`    VARCHAR(255) DEFAULT NULL,
                `active`          TINYINT DEFAULT 1 NOT NULL,
                `name`            VARCHAR(255) DEFAULT NULL,
                `priority`        INT UNSIGNED DEFAULT 0 NOT NULL,
                `link_type`       VARCHAR(15) DEFAULT NULL,
                `link_url`        VARCHAR(255) DEFAULT NULL,
                `link_target`     VARCHAR(15) DEFAULT NULL,
                `link_no_follow`  TINYINT DEFAULT 0 NOT NULL,
                `alt`             VARCHAR(255) DEFAULT NULL,
                `site_id`         BINARY(16) DEFAULT NULL,
                `link_page_id`    BINARY(16) DEFAULT NULL,
                `link_article_id` BINARY(16) DEFAULT NULL,

                INDEX `fk_site_id` (`site_id`),
                INDEX `idx_active` (`active`),
                INDEX `fk_link_page` (`link_page_id`),
                INDEX `fk_link_article_id` (`link_article_id`),
                INDEX `idx_created_at` (`created_at`),
                INDEX `idx_updated_at` (`updated_at`),
                UNIQUE INDEX `uniq_id` (`id`),
                PRIMARY KEY (`id`)

            ) DEFAULT CHARACTER SET utf8mb4
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            CREATE TABLE `site_settings` (
                `id`                    BINARY(16) NOT NULL,
                `created_at`            DATETIME(6) DEFAULT NULL,
                `updated_at`            DATETIME(6) DEFAULT NULL,
                `sender_name`           VARCHAR(255) DEFAULT NULL,
                `sender_email`          VARCHAR(255) DEFAULT NULL,
                `from_name`             VARCHAR(255) DEFAULT NULL,
                `from_email`            VARCHAR(255) DEFAULT NULL,
                `theme_primary_color`   VARCHAR(7) DEFAULT NULL,
                `theme_text_color`      VARCHAR(7) DEFAULT NULL,
                `theme_top_bg_color`    VARCHAR(7) DEFAULT NULL,
                `theme_footer_bg_color` VARCHAR(7) DEFAULT NULL,
                `image_title`           VARCHAR(255) DEFAULT NULL,
                `image_position`        VARCHAR(255) DEFAULT NULL,
                `desktop_image`         VARCHAR(255) DEFAULT NULL,
                `mobile_image`          VARCHAR(255) DEFAULT NULL,
                `link_active`           TINYINT DEFAULT 1 NOT NULL,
                `link_title`            VARCHAR(255) DEFAULT NULL,
                `link_type`             VARCHAR(15) DEFAULT NULL,
                `link_url`              VARCHAR(255) DEFAULT NULL,
                `link_target`           VARCHAR(15) DEFAULT NULL,
                `link_no_follow`        TINYINT DEFAULT 0 NOT NULL,
                `favicon`               VARCHAR(255) DEFAULT NULL,
                `site_id`               BINARY(16) DEFAULT NULL,
                `link_page_id`          BINARY(16) DEFAULT NULL,
                `link_article_id`       BINARY(16) DEFAULT NULL,

                UNIQUE INDEX `UNIQ_E9081F1FF6BD1646` (`site_id`),
                INDEX `fk_site_id` (`site_id`),
                INDEX `idx_link_active` (`link_active`),
                INDEX `fk_link_page` (`link_page_id`),
                INDEX `fk_link_article_id` (`link_article_id`),
                INDEX `idx_created_at` (`created_at`),
                INDEX `idx_updated_at` (`updated_at`),
                UNIQUE INDEX `uniq_id` (`id`),
                PRIMARY KEY (`id`)

            ) DEFAULT CHARACTER SET utf8mb4
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            CREATE TABLE `sites` (
                `id`                      BINARY(16) NOT NULL,
                `created_at`              DATETIME(6) DEFAULT NULL,
                `updated_at`              DATETIME(6) DEFAULT NULL,
                `domain`                  VARCHAR(255) NOT NULL,
                `token`                   VARCHAR(40) DEFAULT NULL,
                `active`                  TINYINT DEFAULT 1 NOT NULL,
                `title`                   VARCHAR(255) DEFAULT NULL,
                `registrar_email`         VARCHAR(255) DEFAULT NULL,
                `registrar_name`          VARCHAR(255) DEFAULT NULL,
                `registered_at`           DATETIME(6) DEFAULT NULL,
                `expire_at`               DATETIME(6) DEFAULT NULL,
                `archive_birth_year`      INT UNSIGNED DEFAULT NULL,
                `global_search_volume`    DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
                `us_search_volume`        DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
                `moz_spam`                DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
                `ahrefs_domain_rating`    DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
                `ahrefs_back_links`       DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
                `ahrefs_ref_domains`      DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
                `semrush_authority_score` DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
                `semrush_back_links`      DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
                `semrush_ref_domains`     DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
                `wikipedia_link`          VARCHAR(255) DEFAULT NULL,
                `is_penalty`              TINYINT DEFAULT 0 NOT NULL,

                INDEX `idx_active` (`active`),
                INDEX `idx_registrar_email` (`registrar_email`),
                INDEX `idx_registered_at` (`registered_at`),
                INDEX `idx_expire_at` (`expire_at`),
                INDEX `idx_created_at` (`created_at`),
                INDEX `idx_updated_at` (`updated_at`),
                UNIQUE INDEX `uniq_domain` (`domain`),
                UNIQUE INDEX `uniq_token` (`token`),
                UNIQUE INDEX `uniq_id` (`id`),
                PRIMARY KEY (`id`)

            ) DEFAULT CHARACTER SET utf8mb4
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            CREATE TABLE `users` (
                `id`                              BINARY(16) NOT NULL,
                `created_at`                      DATETIME(6) DEFAULT NULL,
                `updated_at`                      DATETIME(6) DEFAULT NULL,
                `email`                           VARCHAR(255) NOT NULL,
                `active`                          TINYINT DEFAULT 1 NOT NULL,
                `first_name`                      VARCHAR(255) DEFAULT NULL,
                `last_name`                       VARCHAR(255) DEFAULT NULL,
                `is_google_authenticator_enabled` TINYINT DEFAULT 0 NOT NULL,
                `google_authenticator_token`      VARCHAR(255) DEFAULT NULL,
                `password`                        VARCHAR(255) DEFAULT NULL,
                `roles`                           JSON NOT NULL,

                INDEX `idx_active` (`active`),
                INDEX `idx_google_authenticator_enabled` (`is_google_authenticator_enabled`),
                INDEX `idx_google_authenticator_token` (`google_authenticator_token`),
                INDEX `idx_created_at` (`created_at`),
                INDEX `idx_updated_at` (`updated_at`),
                UNIQUE INDEX `uniq_email` (`email`),
                UNIQUE INDEX `uniq_id` (`id`),
                PRIMARY KEY (`id`)

            ) DEFAULT CHARACTER SET utf8mb4
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            CREATE TABLE `user_sites` (
                `user_id` BINARY(16) NOT NULL,
                `site_id` BINARY(16) NOT NULL,

                INDEX `IDX_5EC2513BA76ED395` (`user_id`),
                INDEX `IDX_5EC2513BF6BD1646` (`site_id`),
                PRIMARY KEY (`user_id`, `site_id`)

            ) DEFAULT CHARACTER SET utf8mb4
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `navigations`
                ADD CONSTRAINT `FK_AD21D8F3727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `navigations` (`id`) ON DELETE CASCADE
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `navigations`
                ADD CONSTRAINT `FK_AD21D8F3F6BD1646` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE CASCADE
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `navigations`
                ADD CONSTRAINT `FK_AD21D8F371203911` FOREIGN KEY (`link_page_id`) REFERENCES `pages` (`id`) ON DELETE SET NULL
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `navigations`
                ADD CONSTRAINT `FK_AD21D8F3251E4669` FOREIGN KEY (`link_article_id`) REFERENCES `pages` (`id`) ON DELETE SET NULL
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `page_related_articles`
                ADD CONSTRAINT `FK_78593719C4663E4` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `page_related_articles`
                ADD CONSTRAINT `FK_785937197294869C` FOREIGN KEY (`article_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `pages`
                ADD CONSTRAINT `FK_2074E575F6BD1646` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE CASCADE
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `site_banners`
                ADD CONSTRAINT `FK_DEABC7A3F6BD1646` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE CASCADE
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `site_banners`
                ADD CONSTRAINT `FK_DEABC7A371203911` FOREIGN KEY (`link_page_id`) REFERENCES `pages` (`id`) ON DELETE SET NULL
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `site_banners`
                ADD CONSTRAINT `FK_DEABC7A3251E4669` FOREIGN KEY (`link_article_id`) REFERENCES `pages` (`id`) ON DELETE SET NULL
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `site_settings`
                ADD CONSTRAINT `FK_E9081F1FF6BD1646` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE CASCADE
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `site_settings`
                ADD CONSTRAINT `FK_E9081F1F71203911` FOREIGN KEY (`link_page_id`) REFERENCES `pages` (`id`) ON DELETE SET NULL
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `site_settings`
                ADD CONSTRAINT `FK_E9081F1F251E4669` FOREIGN KEY (`link_article_id`) REFERENCES `pages` (`id`) ON DELETE SET NULL
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `user_sites`
                ADD CONSTRAINT `FK_5EC2513BA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `user_sites`
                ADD CONSTRAINT `FK_5EC2513BF6BD1646` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE CASCADE
            '
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `navigations`
                DROP FOREIGN KEY `FK_AD21D8F3727ACA70`
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `navigations`
                DROP FOREIGN KEY `FK_AD21D8F3F6BD1646`
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `navigations`
                DROP FOREIGN KEY `FK_AD21D8F371203911`
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `navigations`
                DROP FOREIGN KEY `FK_AD21D8F3251E4669`
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `page_related_articles`
                DROP FOREIGN KEY `FK_78593719C4663E4`
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `page_related_articles`
                DROP FOREIGN KEY `FK_785937197294869C`
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `pages`
                DROP FOREIGN KEY `FK_2074E575F6BD1646`
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `site_banners`
                DROP FOREIGN KEY `FK_DEABC7A3F6BD1646`
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `site_banners`
                DROP FOREIGN KEY `FK_DEABC7A371203911`
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `site_banners`
                DROP FOREIGN KEY `FK_DEABC7A3251E4669`
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `site_settings`
                DROP FOREIGN KEY `FK_E9081F1FF6BD1646`
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `site_settings`
                DROP FOREIGN KEY `FK_E9081F1F71203911`
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `site_settings`
                DROP FOREIGN KEY `FK_E9081F1F251E4669`
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `user_sites`
                DROP FOREIGN KEY `FK_5EC2513BA76ED395`
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            ALTER TABLE `user_sites`
                DROP FOREIGN KEY `FK_5EC2513BF6BD1646`
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            DROP TABLE `navigations`
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            DROP TABLE `page_related_articles`
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            DROP TABLE `pages`
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            DROP TABLE `site_banners`
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            DROP TABLE `site_settings`
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            DROP TABLE `sites`
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            DROP TABLE `users`
            '
        );

        $this->addSql(
        /** @lang MySQL */ '
            DROP TABLE `user_sites`
            '
        );
    }
}
