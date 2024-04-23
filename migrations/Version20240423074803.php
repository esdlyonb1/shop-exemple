<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240423074803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD image_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD image_size INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN image.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F4584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_C53D045F4584665A ON image (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE image DROP CONSTRAINT FK_C53D045F4584665A');
        $this->addSql('DROP INDEX IDX_C53D045F4584665A');
        $this->addSql('ALTER TABLE image DROP product_id');
        $this->addSql('ALTER TABLE image DROP image_name');
        $this->addSql('ALTER TABLE image DROP image_size');
        $this->addSql('ALTER TABLE image DROP updated_at');
    }
}
