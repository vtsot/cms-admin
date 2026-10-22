<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261021094743 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX uniq_id ON banners (id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_id ON brands (id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_id ON contacts (id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_id ON email_templates (id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_id ON faq_groups (id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_id ON faqs (id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_id ON gallery_images (id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_id ON generic_names (id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_id ON mail_logs (id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_id ON navigations (id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_id ON page_related_articles (id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_id ON pages (id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_id ON review_question_items (id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_id ON reviews (id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_id ON site_settings (id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_id ON site_themes (id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_id ON sites (id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_id ON users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX uniq_id ON banners');
        $this->addSql('DROP INDEX uniq_id ON brands');
        $this->addSql('DROP INDEX uniq_id ON contacts');
        $this->addSql('DROP INDEX uniq_id ON email_templates');
        $this->addSql('DROP INDEX uniq_id ON faq_groups');
        $this->addSql('DROP INDEX uniq_id ON faqs');
        $this->addSql('DROP INDEX uniq_id ON gallery_images');
        $this->addSql('DROP INDEX uniq_id ON generic_names');
        $this->addSql('DROP INDEX uniq_id ON mail_logs');
        $this->addSql('DROP INDEX uniq_id ON navigations');
        $this->addSql('DROP INDEX uniq_id ON page_related_articles');
        $this->addSql('DROP INDEX uniq_id ON pages');
        $this->addSql('DROP INDEX uniq_id ON review_question_items');
        $this->addSql('DROP INDEX uniq_id ON reviews');
        $this->addSql('DROP INDEX uniq_id ON site_settings');
        $this->addSql('DROP INDEX uniq_id ON site_themes');
        $this->addSql('DROP INDEX uniq_id ON sites');
        $this->addSql('DROP INDEX uniq_id ON users');
    }
}
