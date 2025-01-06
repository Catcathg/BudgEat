<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250106141918 extends AbstractMigration
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
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clients CHANGE budget budget INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commander CHANGE commentaire_supp commentaire_supp TEXT NOT NULL, CHANGE commentaire_resto commentaire_resto TEXT NOT NULL');
    }
}
