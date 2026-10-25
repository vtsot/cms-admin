<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261026080000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE site_redirects (id BINARY(16) NOT NULL, created_at DATETIME(6) DEFAULT NULL, source_path VARCHAR(255) NOT NULL, target_path VARCHAR(255) NOT NULL, status_code SMALLINT UNSIGNED DEFAULT 301 NOT NULL, type VARCHAR(255) DEFAULT \'permanent\' NOT NULL, site_id BINARY(16) DEFAULT NULL, INDEX fk_site_id (site_id), UNIQUE INDEX uniq_site_source (site_id, source_path), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE site_redirects ADD CONSTRAINT FK_6A3C1A4F6BD1646 FOREIGN KEY (site_id) REFERENCES sites (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pages ADD sources_title VARCHAR(255) DEFAULT NULL, CHANGE redirect redirect VARCHAR(500) DEFAULT NULL, DROP INDEX idx_homepage');
        $this->addSql('CREATE INDEX idx_slug ON pages (slug)');
        $this->addSql('ALTER TABLE navigations RENAME INDEX fk_site_id TO idx_navigation_site_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE site_redirects DROP FOREIGN KEY FK_6A3C1A4F6BD1646');
        $this->addSql('DROP TABLE site_redirects');
        $this->addSql('ALTER TABLE pages DROP sources_title, CHANGE redirect redirect VARCHAR(255) DEFAULT NULL, ADD INDEX idx_homepage (homepage)');
        $this->addSql('DROP INDEX idx_slug ON pages');
        $this->addSql('ALTER TABLE navigations RENAME INDEX idx_navigation_site_id TO fk_site_id');
    }
}
