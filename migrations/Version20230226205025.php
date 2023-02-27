<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230226205025 extends AbstractMigration
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
    }

    /**
    *
    * @param array
    *
    */
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
    }
}
