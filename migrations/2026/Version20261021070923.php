<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261021070923 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE banners (id BINARY(16) NOT NULL, created_at DATETIME(6) DEFAULT NULL, updated_at DATETIME(6) DEFAULT NULL, desktop_image VARCHAR(255) DEFAULT NULL, mobile_image VARCHAR(255) DEFAULT NULL, active TINYINT DEFAULT 1 NOT NULL, name VARCHAR(255) DEFAULT NULL, priority INT UNSIGNED DEFAULT 0 NOT NULL, link_type VARCHAR(15) DEFAULT NULL, link_url VARCHAR(255) DEFAULT NULL, link_target VARCHAR(15) DEFAULT NULL, link_no_follow TINYINT DEFAULT 0 NOT NULL, alt VARCHAR(255) DEFAULT NULL, site_id BINARY(16) DEFAULT NULL, link_page_id BINARY(16) DEFAULT NULL, link_article_id BINARY(16) DEFAULT NULL, INDEX fk_site_id (site_id), INDEX idx_active (active), INDEX fk_link_page (link_page_id), INDEX fk_link_article_id (link_article_id), INDEX idx_created_at (created_at), INDEX idx_updated_at (updated_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE brands (id BINARY(16) NOT NULL, created_at DATETIME(6) DEFAULT NULL, updated_at DATETIME(6) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, INDEX idx_created_at (created_at), INDEX idx_updated_at (updated_at), UNIQUE INDEX uniq_name (name), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE brand_sites (brand_id BINARY(16) NOT NULL, site_id BINARY(16) NOT NULL, INDEX IDX_E7F9637444F5D008 (brand_id), INDEX IDX_E7F96374F6BD1646 (site_id), PRIMARY KEY (brand_id, site_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE contacts (id BINARY(16) NOT NULL, created_at DATETIME(6) DEFAULT NULL, updated_at DATETIME(6) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, message LONGTEXT DEFAULT NULL, site_id BINARY(16) DEFAULT NULL, INDEX fk_site_id (site_id), INDEX idx_created_at (created_at), INDEX idx_updated_at (updated_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE email_templates (id BINARY(16) NOT NULL, created_at DATETIME(6) DEFAULT NULL, updated_at DATETIME(6) DEFAULT NULL, active TINYINT DEFAULT 1 NOT NULL, code VARCHAR(255) DEFAULT NULL, send_to_managers_active TINYINT DEFAULT 0 NOT NULL, send_to VARCHAR(255) DEFAULT NULL, reply_to VARCHAR(255) DEFAULT NULL, subject VARCHAR(255) DEFAULT NULL, html LONGTEXT DEFAULT NULL, text LONGTEXT DEFAULT NULL, site_id BINARY(16) DEFAULT NULL, INDEX fk_site_id (site_id), INDEX idx_active (active), INDEX idx_send_to_managers_active (send_to_managers_active), INDEX idx_created_at (created_at), INDEX idx_updated_at (updated_at), UNIQUE INDEX uniq_site_code (code, site_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE faq_groups (id BINARY(16) NOT NULL, created_at DATETIME(6) DEFAULT NULL, updated_at DATETIME(6) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, active TINYINT DEFAULT 1 NOT NULL, site_id BINARY(16) DEFAULT NULL, INDEX idx_active (active), INDEX fk_site_id (site_id), INDEX idx_created_at (created_at), INDEX idx_updated_at (updated_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE faqs (id BINARY(16) NOT NULL, created_at DATETIME(6) DEFAULT NULL, updated_at DATETIME(6) DEFAULT NULL, position INT DEFAULT 0 NOT NULL, active TINYINT DEFAULT 1 NOT NULL, title VARCHAR(255) DEFAULT NULL, content LONGTEXT DEFAULT NULL, faq_group_id BINARY(16) NOT NULL, INDEX idx_active (active), INDEX fk_faq_group_id (faq_group_id), INDEX idx_created_at (created_at), INDEX idx_updated_at (updated_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE gallery_images (id BINARY(16) NOT NULL, created_at DATETIME(6) DEFAULT NULL, updated_at DATETIME(6) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, color VARCHAR(255) DEFAULT NULL, shape VARCHAR(255) DEFAULT NULL, imprint TEXT DEFAULT NULL, active TINYINT DEFAULT 1 NOT NULL, title VARCHAR(255) DEFAULT NULL, position INT DEFAULT 0 NOT NULL, content LONGTEXT DEFAULT NULL, link_type VARCHAR(15) DEFAULT NULL, link_url VARCHAR(255) DEFAULT NULL, link_target VARCHAR(15) DEFAULT NULL, link_no_follow TINYINT DEFAULT 0 NOT NULL, alt VARCHAR(255) DEFAULT NULL, site_id BINARY(16) DEFAULT NULL, link_page_id BINARY(16) DEFAULT NULL, link_article_id BINARY(16) DEFAULT NULL, INDEX fk_site_id (site_id), INDEX idx_active (active), INDEX fk_link_page (link_page_id), INDEX fk_link_article (link_article_id), INDEX idx_created_at (created_at), INDEX idx_updated_at (updated_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE generic_names (id BINARY(16) NOT NULL, created_at DATETIME(6) DEFAULT NULL, updated_at DATETIME(6) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, INDEX idx_created_at (created_at), INDEX idx_updated_at (updated_at), UNIQUE INDEX uniq_name (name), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE generic_name_sites (generic_name_id BINARY(16) NOT NULL, site_id BINARY(16) NOT NULL, INDEX IDX_298E96ABCC59BE87 (generic_name_id), INDEX IDX_298E96ABF6BD1646 (site_id), PRIMARY KEY (generic_name_id, site_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE mail_logs (id BINARY(16) NOT NULL, created_at DATETIME(6) DEFAULT NULL, updated_at DATETIME(6) DEFAULT NULL, message_id VARCHAR(255) DEFAULT NULL, status VARCHAR(255) NOT NULL, debug LONGTEXT DEFAULT NULL, sender VARCHAR(255) DEFAULT NULL, reply_to VARCHAR(255) DEFAULT NULL, return_path VARCHAR(255) DEFAULT NULL, recipient VARCHAR(255) DEFAULT NULL, cc VARCHAR(255) DEFAULT NULL, bcc VARCHAR(255) DEFAULT NULL, subject VARCHAR(255) DEFAULT NULL, text LONGTEXT DEFAULT NULL, html LONGTEXT DEFAULT NULL, site_id BINARY(16) DEFAULT NULL, INDEX fk_site_id (site_id), INDEX idx_recipient (recipient), INDEX idx_created_at (created_at), INDEX idx_updated_at (updated_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE navigations (id BINARY(16) NOT NULL, created_at DATETIME(6) DEFAULT NULL, updated_at DATETIME(6) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, active TINYINT DEFAULT 1 NOT NULL, title VARCHAR(255) DEFAULT NULL, link_type VARCHAR(15) DEFAULT NULL, link_url VARCHAR(255) DEFAULT NULL, link_target VARCHAR(15) DEFAULT NULL, link_no_follow TINYINT DEFAULT 0 NOT NULL, position INT DEFAULT 0 NOT NULL, parent_id BINARY(16) DEFAULT NULL, site_id BINARY(16) DEFAULT NULL, link_page_id BINARY(16) DEFAULT NULL, link_article_id BINARY(16) DEFAULT NULL, entity VARCHAR(255) NOT NULL, INDEX idx_parent_id (parent_id), INDEX fk_link_page (link_page_id), INDEX fk_link_article (link_article_id), INDEX idx_active (active), INDEX fk_site_id (site_id), INDEX idx_created_at (created_at), INDEX idx_updated_at (updated_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE page_related_articles (id BINARY(16) NOT NULL, created_at DATETIME(6) DEFAULT NULL, updated_at DATETIME(6) DEFAULT NULL, active TINYINT DEFAULT 1 NOT NULL, position INT DEFAULT 0 NOT NULL, page_id BINARY(16) DEFAULT NULL, article_id BINARY(16) DEFAULT NULL, INDEX fk_page_id (page_id), INDEX fk_article_id (article_id), INDEX idx_active (active), INDEX idx_created_at (created_at), INDEX idx_updated_at (updated_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE pages (id BINARY(16) NOT NULL, created_at DATETIME(6) DEFAULT NULL, updated_at DATETIME(6) DEFAULT NULL, homepage TINYINT DEFAULT 0 NOT NULL, active TINYINT DEFAULT 1 NOT NULL, title VARCHAR(255) DEFAULT NULL, content LONGTEXT DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, meta_title VARCHAR(255) DEFAULT NULL, meta_keywords VARCHAR(1000) DEFAULT NULL, meta_description VARCHAR(1000) DEFAULT NULL, og_title VARCHAR(255) DEFAULT NULL, og_description LONGTEXT DEFAULT NULL, og_image LONGTEXT DEFAULT NULL, is_indexed TINYINT DEFAULT 1 NOT NULL, sitemap_change_frequency VARCHAR(255) DEFAULT \'weekly\' NOT NULL, sitemap_priority DOUBLE PRECISION DEFAULT 0.5 NOT NULL, redirect VARCHAR(255) DEFAULT NULL, code_block LONGTEXT DEFAULT NULL, sources TEXT DEFAULT NULL, site_id BINARY(16) DEFAULT NULL, entity VARCHAR(255) NOT NULL, related_articles_title VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, alt VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, INDEX fk_site_id (site_id), INDEX idx_active (active), INDEX idx_homepage (homepage), INDEX idx_created_at (created_at), INDEX idx_updated_at (updated_at), UNIQUE INDEX uniq_site_slug (slug, site_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE review_question_items (id BINARY(16) NOT NULL, created_at DATETIME(6) DEFAULT NULL, updated_at DATETIME(6) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, active TINYINT DEFAULT 1 NOT NULL, position INT DEFAULT 0 NOT NULL, site_id BINARY(16) DEFAULT NULL, entity VARCHAR(255) NOT NULL, INDEX idx_active (active), INDEX fk_site_id (site_id), INDEX idx_created_at (created_at), INDEX idx_updated_at (updated_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE reviews (id BINARY(16) NOT NULL, created_at DATETIME(6) DEFAULT NULL, updated_at DATETIME(6) DEFAULT NULL, author_name VARCHAR(255) DEFAULT NULL, author_gender VARCHAR(255) DEFAULT NULL, author_type VARCHAR(255) DEFAULT NULL, effectiveness SMALLINT UNSIGNED DEFAULT 0 NOT NULL, like_quantity SMALLINT UNSIGNED DEFAULT 0 NOT NULL, dislike_quantity SMALLINT UNSIGNED DEFAULT 0 NOT NULL, report_quantity SMALLINT UNSIGNED DEFAULT 0 NOT NULL, ease_of_use SMALLINT UNSIGNED DEFAULT 0 NOT NULL, satisfaction SMALLINT UNSIGNED DEFAULT 0 NOT NULL, full_name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, other_product_name VARCHAR(255) DEFAULT NULL, other_product_manufacturer VARCHAR(255) DEFAULT NULL, active TINYINT DEFAULT 1 NOT NULL, content LONGTEXT DEFAULT NULL, reason_id BINARY(16) DEFAULT NULL, author_age_id BINARY(16) DEFAULT NULL, medication_time_id BINARY(16) DEFAULT NULL, site_id BINARY(16) DEFAULT NULL, product_id BINARY(16) DEFAULT NULL, INDEX idx_active (active), INDEX fk_site_id (site_id), INDEX fk_reason_id (reason_id), INDEX fk_author_age_id (author_age_id), INDEX fk_medication_time_id (medication_time_id), INDEX fk_product_id (product_id), INDEX idx_created_at (created_at), INDEX idx_updated_at (updated_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE site_settings (id BINARY(16) NOT NULL, created_at DATETIME(6) DEFAULT NULL, updated_at DATETIME(6) DEFAULT NULL, sender_name VARCHAR(255) DEFAULT NULL, sender_email VARCHAR(255) DEFAULT NULL, from_name VARCHAR(255) DEFAULT NULL, from_email VARCHAR(255) DEFAULT NULL, theme_primary_color VARCHAR(7) DEFAULT NULL, theme_text_color VARCHAR(7) DEFAULT NULL, theme_top_bg_color VARCHAR(7) DEFAULT NULL, theme_footer_bg_color VARCHAR(7) DEFAULT NULL, image_title VARCHAR(255) DEFAULT NULL, image_position VARCHAR(255) DEFAULT NULL, desktop_image VARCHAR(255) DEFAULT NULL, mobile_image VARCHAR(255) DEFAULT NULL, link_active TINYINT DEFAULT 1 NOT NULL, link_title VARCHAR(255) DEFAULT NULL, link_type VARCHAR(15) DEFAULT NULL, link_url VARCHAR(255) DEFAULT NULL, link_target VARCHAR(15) DEFAULT NULL, link_no_follow TINYINT DEFAULT 0 NOT NULL, favicon VARCHAR(255) DEFAULT NULL, site_id BINARY(16) DEFAULT NULL, link_page_id BINARY(16) DEFAULT NULL, link_article_id BINARY(16) DEFAULT NULL, UNIQUE INDEX UNIQ_E9081F1FF6BD1646 (site_id), INDEX fk_site_id (site_id), INDEX idx_link_active (link_active), INDEX fk_link_page (link_page_id), INDEX fk_link_article_id (link_article_id), INDEX idx_created_at (created_at), INDEX idx_updated_at (updated_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE site_themes (id BINARY(16) NOT NULL, created_at DATETIME(6) DEFAULT NULL, updated_at DATETIME(6) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, INDEX idx_created_at (created_at), INDEX idx_updated_at (updated_at), UNIQUE INDEX uniq_code (code), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE sites (id BINARY(16) NOT NULL, created_at DATETIME(6) DEFAULT NULL, updated_at DATETIME(6) DEFAULT NULL, domain VARCHAR(255) NOT NULL, token VARCHAR(40) DEFAULT NULL, footer_text1 TEXT DEFAULT NULL, footer_text2 TEXT DEFAULT NULL, copyright_text TEXT DEFAULT NULL, active TINYINT DEFAULT 1 NOT NULL, title VARCHAR(255) DEFAULT NULL, registrar_email VARCHAR(255) DEFAULT NULL, registrar_name VARCHAR(255) DEFAULT NULL, registered_at DATETIME(6) DEFAULT NULL, expire_at DATETIME(6) DEFAULT NULL, archive_birth_year INT UNSIGNED DEFAULT NULL, global_search_volume DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL, us_search_volume DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL, moz_spam DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL, ahrefs_domain_rating DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL, ahrefs_back_links DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL, ahrefs_ref_domains DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL, semrush_authority_score DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL, semrush_back_links DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL, semrush_ref_domains DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL, wikipedia_link VARCHAR(255) DEFAULT NULL, is_penalty TINYINT DEFAULT 0 NOT NULL, site_theme_id BINARY(16) DEFAULT NULL, INDEX idx_active (active), INDEX fk_site_theme_id (site_theme_id), INDEX idx_registrar_email (registrar_email), INDEX idx_registered_at (registered_at), INDEX idx_expire_at (expire_at), INDEX idx_is_penalty (is_penalty), INDEX idx_created_at (created_at), INDEX idx_updated_at (updated_at), UNIQUE INDEX uniq_domain (domain), UNIQUE INDEX uniq_token (token), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE users (id BINARY(16) NOT NULL, created_at DATETIME(6) DEFAULT NULL, updated_at DATETIME(6) DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) DEFAULT NULL, roles JSON NOT NULL, is_google_authenticator_enabled TINYINT DEFAULT 0 NOT NULL, google_authenticator_token VARCHAR(255) DEFAULT NULL, active TINYINT DEFAULT 1 NOT NULL, INDEX idx_active (active), INDEX idx_google_authenticator_enabled (is_google_authenticator_enabled), INDEX idx_created_at (created_at), INDEX idx_updated_at (updated_at), UNIQUE INDEX uniq_email (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user_sites (user_id BINARY(16) NOT NULL, site_id BINARY(16) NOT NULL, INDEX IDX_5EC2513BA76ED395 (user_id), INDEX IDX_5EC2513BF6BD1646 (site_id), PRIMARY KEY (user_id, site_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE banners ADD CONSTRAINT FK_250F2568F6BD1646 FOREIGN KEY (site_id) REFERENCES sites (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE banners ADD CONSTRAINT FK_250F256871203911 FOREIGN KEY (link_page_id) REFERENCES pages (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE banners ADD CONSTRAINT FK_250F2568251E4669 FOREIGN KEY (link_article_id) REFERENCES pages (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE brand_sites ADD CONSTRAINT FK_E7F9637444F5D008 FOREIGN KEY (brand_id) REFERENCES brands (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brand_sites ADD CONSTRAINT FK_E7F96374F6BD1646 FOREIGN KEY (site_id) REFERENCES sites (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contacts ADD CONSTRAINT FK_33401573F6BD1646 FOREIGN KEY (site_id) REFERENCES sites (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE email_templates ADD CONSTRAINT FK_6023E2A5F6BD1646 FOREIGN KEY (site_id) REFERENCES sites (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE faq_groups ADD CONSTRAINT FK_80A31925F6BD1646 FOREIGN KEY (site_id) REFERENCES sites (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE faqs ADD CONSTRAINT FK_8934BEE52F62050 FOREIGN KEY (faq_group_id) REFERENCES faq_groups (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gallery_images ADD CONSTRAINT FK_429C52C8F6BD1646 FOREIGN KEY (site_id) REFERENCES sites (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gallery_images ADD CONSTRAINT FK_429C52C871203911 FOREIGN KEY (link_page_id) REFERENCES pages (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE gallery_images ADD CONSTRAINT FK_429C52C8251E4669 FOREIGN KEY (link_article_id) REFERENCES pages (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE generic_name_sites ADD CONSTRAINT FK_298E96ABCC59BE87 FOREIGN KEY (generic_name_id) REFERENCES generic_names (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE generic_name_sites ADD CONSTRAINT FK_298E96ABF6BD1646 FOREIGN KEY (site_id) REFERENCES sites (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mail_logs ADD CONSTRAINT FK_5DF45535F6BD1646 FOREIGN KEY (site_id) REFERENCES sites (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE navigations ADD CONSTRAINT FK_AD21D8F3727ACA70 FOREIGN KEY (parent_id) REFERENCES navigations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE navigations ADD CONSTRAINT FK_AD21D8F3F6BD1646 FOREIGN KEY (site_id) REFERENCES sites (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE navigations ADD CONSTRAINT FK_AD21D8F371203911 FOREIGN KEY (link_page_id) REFERENCES pages (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE navigations ADD CONSTRAINT FK_AD21D8F3251E4669 FOREIGN KEY (link_article_id) REFERENCES pages (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE page_related_articles ADD CONSTRAINT FK_78593719C4663E4 FOREIGN KEY (page_id) REFERENCES pages (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_related_articles ADD CONSTRAINT FK_785937197294869C FOREIGN KEY (article_id) REFERENCES pages (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pages ADD CONSTRAINT FK_2074E575F6BD1646 FOREIGN KEY (site_id) REFERENCES sites (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE review_question_items ADD CONSTRAINT FK_CD2B266F6BD1646 FOREIGN KEY (site_id) REFERENCES sites (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F59BB1592 FOREIGN KEY (reason_id) REFERENCES review_question_items (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F2943FB3F FOREIGN KEY (author_age_id) REFERENCES review_question_items (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0FF9CDBD03 FOREIGN KEY (medication_time_id) REFERENCES review_question_items (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0FF6BD1646 FOREIGN KEY (site_id) REFERENCES sites (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F4584665A FOREIGN KEY (product_id) REFERENCES review_question_items (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE site_settings ADD CONSTRAINT FK_E9081F1FF6BD1646 FOREIGN KEY (site_id) REFERENCES sites (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE site_settings ADD CONSTRAINT FK_E9081F1F71203911 FOREIGN KEY (link_page_id) REFERENCES pages (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE site_settings ADD CONSTRAINT FK_E9081F1F251E4669 FOREIGN KEY (link_article_id) REFERENCES pages (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE sites ADD CONSTRAINT FK_BC00AA63554FCB5D FOREIGN KEY (site_theme_id) REFERENCES site_themes (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE user_sites ADD CONSTRAINT FK_5EC2513BA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_sites ADD CONSTRAINT FK_5EC2513BF6BD1646 FOREIGN KEY (site_id) REFERENCES sites (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE banners DROP FOREIGN KEY FK_250F2568F6BD1646');
        $this->addSql('ALTER TABLE banners DROP FOREIGN KEY FK_250F256871203911');
        $this->addSql('ALTER TABLE banners DROP FOREIGN KEY FK_250F2568251E4669');
        $this->addSql('ALTER TABLE brand_sites DROP FOREIGN KEY FK_E7F9637444F5D008');
        $this->addSql('ALTER TABLE brand_sites DROP FOREIGN KEY FK_E7F96374F6BD1646');
        $this->addSql('ALTER TABLE contacts DROP FOREIGN KEY FK_33401573F6BD1646');
        $this->addSql('ALTER TABLE email_templates DROP FOREIGN KEY FK_6023E2A5F6BD1646');
        $this->addSql('ALTER TABLE faq_groups DROP FOREIGN KEY FK_80A31925F6BD1646');
        $this->addSql('ALTER TABLE faqs DROP FOREIGN KEY FK_8934BEE52F62050');
        $this->addSql('ALTER TABLE gallery_images DROP FOREIGN KEY FK_429C52C8F6BD1646');
        $this->addSql('ALTER TABLE gallery_images DROP FOREIGN KEY FK_429C52C871203911');
        $this->addSql('ALTER TABLE gallery_images DROP FOREIGN KEY FK_429C52C8251E4669');
        $this->addSql('ALTER TABLE generic_name_sites DROP FOREIGN KEY FK_298E96ABCC59BE87');
        $this->addSql('ALTER TABLE generic_name_sites DROP FOREIGN KEY FK_298E96ABF6BD1646');
        $this->addSql('ALTER TABLE mail_logs DROP FOREIGN KEY FK_5DF45535F6BD1646');
        $this->addSql('ALTER TABLE navigations DROP FOREIGN KEY FK_AD21D8F3727ACA70');
        $this->addSql('ALTER TABLE navigations DROP FOREIGN KEY FK_AD21D8F3F6BD1646');
        $this->addSql('ALTER TABLE navigations DROP FOREIGN KEY FK_AD21D8F371203911');
        $this->addSql('ALTER TABLE navigations DROP FOREIGN KEY FK_AD21D8F3251E4669');
        $this->addSql('ALTER TABLE page_related_articles DROP FOREIGN KEY FK_78593719C4663E4');
        $this->addSql('ALTER TABLE page_related_articles DROP FOREIGN KEY FK_785937197294869C');
        $this->addSql('ALTER TABLE pages DROP FOREIGN KEY FK_2074E575F6BD1646');
        $this->addSql('ALTER TABLE review_question_items DROP FOREIGN KEY FK_CD2B266F6BD1646');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0F59BB1592');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0F2943FB3F');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0FF9CDBD03');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0FF6BD1646');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0F4584665A');
        $this->addSql('ALTER TABLE site_settings DROP FOREIGN KEY FK_E9081F1FF6BD1646');
        $this->addSql('ALTER TABLE site_settings DROP FOREIGN KEY FK_E9081F1F71203911');
        $this->addSql('ALTER TABLE site_settings DROP FOREIGN KEY FK_E9081F1F251E4669');
        $this->addSql('ALTER TABLE sites DROP FOREIGN KEY FK_BC00AA63554FCB5D');
        $this->addSql('ALTER TABLE user_sites DROP FOREIGN KEY FK_5EC2513BA76ED395');
        $this->addSql('ALTER TABLE user_sites DROP FOREIGN KEY FK_5EC2513BF6BD1646');
        $this->addSql('DROP TABLE banners');
        $this->addSql('DROP TABLE brands');
        $this->addSql('DROP TABLE brand_sites');
        $this->addSql('DROP TABLE contacts');
        $this->addSql('DROP TABLE email_templates');
        $this->addSql('DROP TABLE faq_groups');
        $this->addSql('DROP TABLE faqs');
        $this->addSql('DROP TABLE gallery_images');
        $this->addSql('DROP TABLE generic_names');
        $this->addSql('DROP TABLE generic_name_sites');
        $this->addSql('DROP TABLE mail_logs');
        $this->addSql('DROP TABLE navigations');
        $this->addSql('DROP TABLE page_related_articles');
        $this->addSql('DROP TABLE pages');
        $this->addSql('DROP TABLE review_question_items');
        $this->addSql('DROP TABLE reviews');
        $this->addSql('DROP TABLE site_settings');
        $this->addSql('DROP TABLE site_themes');
        $this->addSql('DROP TABLE sites');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE user_sites');
    }
}
