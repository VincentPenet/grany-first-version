<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230226203734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE preferences ADD categorie_produit_id INT NOT NULL');
        $this->addSql('ALTER TABLE preferences ADD CONSTRAINT FK_E931A6F591FDB457 FOREIGN KEY (categorie_produit_id) REFERENCES categorie_produits (id)');
        $this->addSql('CREATE INDEX IDX_E931A6F591FDB457 ON preferences (categorie_produit_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE preferences DROP FOREIGN KEY FK_E931A6F591FDB457');
        $this->addSql('DROP INDEX IDX_E931A6F591FDB457 ON preferences');
        $this->addSql('ALTER TABLE preferences DROP categorie_produit_id');
    }
}
