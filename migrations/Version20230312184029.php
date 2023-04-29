<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230312184029 extends AbstractMigration
{
    private array $titres = [
        [
            'id' => 1,
            'titre' => 'Monsieur',
        ],
        [
            'id' => 2,
            'titre' => 'Madame',
        ],
    ];

    private array $categories = [
        [
            'id' => 1,
            'categorie' => 'peluches amigurumis',
        ],
        [
            'id' => 2,
            'categorie' => 'doudous',
        ],
        [
            'id' => 3,
            'categorie' => 'hochets',
        ],
        [
            'id' => 4,
            'categorie' => 'jouets',
        ],
        [
            'id' => 5,
            'categorie' => 'tapis de sol',
        ],
        [
            'id' => 6,
            'categorie' => 'couvertures',
        ],
        [
            'id' => 7,
            'categorie' => 'chaussons',
        ],
    ];

    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie_produits (id INT AUTO_INCREMENT NOT NULL, categorie VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE civilite (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contacts (id INT AUTO_INCREMENT NOT NULL, civilite_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, cree_le DATETIME NOT NULL, maj_le DATETIME DEFAULT NULL, rgpd_validation INT NOT NULL, INDEX IDX_3340157339194ABF (civilite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE preferences (id INT AUTO_INCREMENT NOT NULL, cree_le DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE preferences ADD categorie_produit_id INT NOT NULL');
        $this->addSql('ALTER TABLE preferences ADD CONSTRAINT FK_E931A6F591FDB457 FOREIGN KEY (categorie_produit_id) REFERENCES categorie_produits (id)');
        $this->addSql('ALTER TABLE preferences ADD contact_id INT NOT NULL');
        $this->addSql('ALTER TABLE preferences ADD CONSTRAINT FK_E931A6F5E7A1254A FOREIGN KEY (contact_id) REFERENCES contacts (id)');
        $this->addSql('ALTER TABLE contacts ADD CONSTRAINT FK_3340157339194ABF FOREIGN KEY (civilite_id) REFERENCES civilite (id)');
        $this->addSql('CREATE TABLE messages (id INT AUTO_INCREMENT NOT NULL, contact_id INT NOT NULL, objet_message VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, cree_le DATETIME NOT NULL, INDEX IDX_DB021E96E7A1254A (contact_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96E7A1254A FOREIGN KEY (contact_id) REFERENCES contacts (id)');
    }
    
    public function postUp(Schema $schema): void
    {
        foreach ($this->titres as $titre) {
            $this->connection->insert('civilite', $titre);
        }

        foreach ($this->categories as $categorie) {
            $this->connection->insert('categorie_produits', $categorie);
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contacts DROP FOREIGN KEY FK_3340157339194ABF');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96E7A1254A');
        $this->addSql('ALTER TABLE preferences DROP FOREIGN KEY FK_E931A6F5E7A1254A');
        $this->addSql('ALTER TABLE preferences DROP FOREIGN KEY FK_E931A6F591FDB457');
        $this->addSql('DROP TABLE categorie_produits');
        $this->addSql('DROP TABLE civilite');
        $this->addSql('DROP TABLE contacts');
        $this->addSql('DROP TABLE messages');
        $this->addSql('DROP TABLE preferences');
    }
}
