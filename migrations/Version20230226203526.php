<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230226203526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE preferences ADD contact_id INT NOT NULL');
        $this->addSql('ALTER TABLE preferences ADD CONSTRAINT FK_E931A6F5E7A1254A FOREIGN KEY (contact_id) REFERENCES contacts (id)');
        $this->addSql('CREATE INDEX IDX_E931A6F5E7A1254A ON preferences (contact_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE preferences DROP FOREIGN KEY FK_E931A6F5E7A1254A');
        $this->addSql('DROP INDEX IDX_E931A6F5E7A1254A ON preferences');
        $this->addSql('ALTER TABLE preferences DROP contact_id');
    }
}
