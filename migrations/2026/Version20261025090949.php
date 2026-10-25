<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261025090949 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Gedmo personal translations for pages and articles';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE page_translations (id INT AUTO_INCREMENT NOT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, object_id BINARY(16) NOT NULL, UNIQUE INDEX uniq_locale_object_field (locale, object_id, field), INDEX IDX_78AB76C9232D562B (object_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE page_translations ADD CONSTRAINT FK_78AB76C9232D562B FOREIGN KEY (object_id) REFERENCES pages (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_translations DROP FOREIGN KEY FK_78AB76C9232D562B');
        $this->addSql('DROP TABLE page_translations');
    }
}
