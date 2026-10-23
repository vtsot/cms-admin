<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261022231451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE site_settings DROP FOREIGN KEY `FK_E9081F1F251E4669`');
        $this->addSql('ALTER TABLE site_settings DROP FOREIGN KEY `FK_E9081F1F71203911`');
        $this->addSql('DROP INDEX fk_link_article_id ON site_settings');
        $this->addSql('DROP INDEX fk_link_page ON site_settings');
        $this->addSql('DROP INDEX idx_link_active ON site_settings');
        $this->addSql('ALTER TABLE site_settings DROP link_active, DROP link_title, DROP link_type, DROP link_url, DROP link_target, DROP link_no_follow, DROP link_page_id, DROP link_article_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE site_settings ADD link_active TINYINT DEFAULT 1 NOT NULL, ADD link_title VARCHAR(255) DEFAULT NULL, ADD link_type VARCHAR(15) DEFAULT NULL, ADD link_url VARCHAR(255) DEFAULT NULL, ADD link_target VARCHAR(15) DEFAULT NULL, ADD link_no_follow TINYINT DEFAULT 0 NOT NULL, ADD link_page_id BINARY(16) DEFAULT NULL, ADD link_article_id BINARY(16) DEFAULT NULL');
        $this->addSql('ALTER TABLE site_settings ADD CONSTRAINT `FK_E9081F1F251E4669` FOREIGN KEY (link_article_id) REFERENCES pages (id) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('ALTER TABLE site_settings ADD CONSTRAINT `FK_E9081F1F71203911` FOREIGN KEY (link_page_id) REFERENCES pages (id) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('CREATE INDEX fk_link_article_id ON site_settings (link_article_id)');
        $this->addSql('CREATE INDEX fk_link_page ON site_settings (link_page_id)');
        $this->addSql('CREATE INDEX idx_link_active ON site_settings (link_active)');
    }
}
