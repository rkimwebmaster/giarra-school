<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230320131308 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE frais ADD COLUMN total_perception DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__frais AS SELECT id, frais_abstrait_id, annee_academique_id, date_butoire, montant FROM frais');
        $this->addSql('DROP TABLE frais');
        $this->addSql('CREATE TABLE frais (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, frais_abstrait_id INTEGER NOT NULL, annee_academique_id INTEGER NOT NULL, date_butoire DATE NOT NULL, montant DOUBLE PRECISION NOT NULL, CONSTRAINT FK_25404C98213B6273 FOREIGN KEY (frais_abstrait_id) REFERENCES frais_abstrait (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_25404C98B00F076 FOREIGN KEY (annee_academique_id) REFERENCES annee_academique (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO frais (id, frais_abstrait_id, annee_academique_id, date_butoire, montant) SELECT id, frais_abstrait_id, annee_academique_id, date_butoire, montant FROM __temp__frais');
        $this->addSql('DROP TABLE __temp__frais');
        $this->addSql('CREATE INDEX IDX_25404C98213B6273 ON frais (frais_abstrait_id)');
        $this->addSql('CREATE INDEX IDX_25404C98B00F076 ON frais (annee_academique_id)');
    }
}
