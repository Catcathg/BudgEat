<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250105015800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clients CHANGE budget budget INT NOT NULL');
        $this->addSql('ALTER TABLE commander CHANGE commentaire_supp commentaire_supp VARCHAR(255) NOT NULL, CHANGE commentaire_resto commentaire_resto VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE restaurants ADD image VARCHAR(255) DEFAULT NULL, ADD rating DOUBLE PRECISION DEFAULT NULL, ADD distance VARCHAR(255) DEFAULT NULL, DROP adresse, DROP code_postal, DROP ville, DROP mail, DROP mdp');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clients CHANGE budget budget INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commander CHANGE commentaire_supp commentaire_supp TEXT NOT NULL, CHANGE commentaire_resto commentaire_resto TEXT NOT NULL');
        $this->addSql('ALTER TABLE restaurants ADD adresse VARCHAR(255) NOT NULL, ADD code_postal INT NOT NULL, ADD ville VARCHAR(255) NOT NULL, ADD mail VARCHAR(255) NOT NULL, ADD mdp VARCHAR(255) NOT NULL, DROP image, DROP rating, DROP distance');
    }
}
