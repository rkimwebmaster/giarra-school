<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230323142552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE frais_abstrait ADD COLUMN is_inscription BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE frais_abstrait ADD COLUMN is_reinscription BOOLEAN NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__frais_abstrait AS SELECT id, designation, description FROM frais_abstrait');
        $this->addSql('DROP TABLE frais_abstrait');
        $this->addSql('CREATE TABLE frais_abstrait (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, designation VARCHAR(180) NOT NULL, description CLOB DEFAULT NULL)');
        $this->addSql('INSERT INTO frais_abstrait (id, designation, description) SELECT id, designation, description FROM __temp__frais_abstrait');
        $this->addSql('DROP TABLE __temp__frais_abstrait');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BD0F24338947610D ON frais_abstrait (designation)');
    }
}
