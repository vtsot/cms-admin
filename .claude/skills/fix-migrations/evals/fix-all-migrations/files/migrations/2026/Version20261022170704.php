<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261022170704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pages CHANGE alt image_alt VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE site_banners CHANGE alt image_alt VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pages CHANGE image_alt alt VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE site_banners CHANGE image_alt alt VARCHAR(255) DEFAULT NULL');
    }
}
