<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20261019182016 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pages (id BINARY(16) NOT NULL, created_at DATETIME(6) DEFAULT NULL, updated_at DATETIME(6) DEFAULT NULL, is_indexed TINYINT DEFAULT 1 NOT NULL, sitemap_change_frequency VARCHAR(255) DEFAULT \'weekly\' NOT NULL, sitemap_priority DOUBLE PRECISION DEFAULT 0.5 NOT NULL, slug VARCHAR(255) DEFAULT NULL, active TINYINT DEFAULT 1 NOT NULL, entity VARCHAR(255) NOT NULL, INDEX idx_active (active), INDEX idx_created_at (created_at), INDEX idx_updated_at (updated_at), UNIQUE INDEX uniq_slug (slug), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE pages');
    }
}
