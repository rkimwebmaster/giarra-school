<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230320125851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annee_academique ADD COLUMN grand_total_frais DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__annee_academique AS SELECT id, debut, fin, is_en_cours, is_passe FROM annee_academique');
        $this->addSql('DROP TABLE annee_academique');
        $this->addSql('CREATE TABLE annee_academique (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, debut INTEGER NOT NULL, fin INTEGER NOT NULL, is_en_cours BOOLEAN NOT NULL, is_passe BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO annee_academique (id, debut, fin, is_en_cours, is_passe) SELECT id, debut, fin, is_en_cours, is_passe FROM __temp__annee_academique');
        $this->addSql('DROP TABLE __temp__annee_academique');
    }
}
