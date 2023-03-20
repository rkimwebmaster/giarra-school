<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230320132742 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__faculte_section AS SELECT id, designation, text FROM faculte_section');
        $this->addSql('DROP TABLE faculte_section');
        $this->addSql('CREATE TABLE faculte_section (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, designation VARCHAR(255) NOT NULL, text VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO faculte_section (id, designation, text) SELECT id, designation, text FROM __temp__faculte_section');
        $this->addSql('DROP TABLE __temp__faculte_section');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_26941DD08947610D ON faculte_section (designation)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__faculte_section AS SELECT id, designation, text FROM faculte_section');
        $this->addSql('DROP TABLE faculte_section');
        $this->addSql('CREATE TABLE faculte_section (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, designation VARCHAR(255) NOT NULL, text VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO faculte_section (id, designation, text) SELECT id, designation, text FROM __temp__faculte_section');
        $this->addSql('DROP TABLE __temp__faculte_section');
    }
}
