<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230321190133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__inscription AS SELECT id, promotion_concrete_id, etudiant_annee_academique_id, date, observation, matricule FROM inscription');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('CREATE TABLE inscription (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, promotion_concrete_id INTEGER NOT NULL, etudiant_annee_academique_id INTEGER NOT NULL, paiement_id INTEGER NOT NULL, date DATETIME NOT NULL, observation VARCHAR(255) DEFAULT NULL, matricule VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_5E90F6D62302286B FOREIGN KEY (promotion_concrete_id) REFERENCES promotion_concrete (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5E90F6D6FD47D769 FOREIGN KEY (etudiant_annee_academique_id) REFERENCES etudiant_annee_academique (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5E90F6D62A4C4478 FOREIGN KEY (paiement_id) REFERENCES paiement (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO inscription (id, promotion_concrete_id, etudiant_annee_academique_id, date, observation, matricule) SELECT id, promotion_concrete_id, etudiant_annee_academique_id, date, observation, matricule FROM __temp__inscription');
        $this->addSql('DROP TABLE __temp__inscription');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5E90F6D6FD47D769 ON inscription (etudiant_annee_academique_id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D62302286B ON inscription (promotion_concrete_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5E90F6D62A4C4478 ON inscription (paiement_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__paiement AS SELECT id, frais_id, utilisateur_id, date_paiement FROM paiement');
        $this->addSql('DROP TABLE paiement');
        $this->addSql('CREATE TABLE paiement (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, frais_id INTEGER NOT NULL, utilisateur_id INTEGER NOT NULL, date_paiement DATE NOT NULL, CONSTRAINT FK_B1DC7A1EBF516DC4 FOREIGN KEY (frais_id) REFERENCES frais (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B1DC7A1EFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO paiement (id, frais_id, utilisateur_id, date_paiement) SELECT id, frais_id, utilisateur_id, date_paiement FROM __temp__paiement');
        $this->addSql('DROP TABLE __temp__paiement');
        $this->addSql('CREATE INDEX IDX_B1DC7A1EFB88E14F ON paiement (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_B1DC7A1EBF516DC4 ON paiement (frais_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reinscription AS SELECT id, promotion_concrete_id, utilisateur_id, etudiant_annee_academique_id, inscription_id, annee_academique_id, date FROM reinscription');
        $this->addSql('DROP TABLE reinscription');
        $this->addSql('CREATE TABLE reinscription (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, promotion_concrete_id INTEGER NOT NULL, utilisateur_id INTEGER DEFAULT NULL, etudiant_annee_academique_id INTEGER NOT NULL, inscription_id INTEGER DEFAULT NULL, annee_academique_id INTEGER NOT NULL, paiement_id INTEGER NOT NULL, date DATETIME NOT NULL, CONSTRAINT FK_503AD36F2302286B FOREIGN KEY (promotion_concrete_id) REFERENCES promotion_concrete (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_503AD36FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_503AD36FFD47D769 FOREIGN KEY (etudiant_annee_academique_id) REFERENCES etudiant_annee_academique (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_503AD36F5DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_503AD36FB00F076 FOREIGN KEY (annee_academique_id) REFERENCES annee_academique (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_503AD36F2A4C4478 FOREIGN KEY (paiement_id) REFERENCES paiement (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO reinscription (id, promotion_concrete_id, utilisateur_id, etudiant_annee_academique_id, inscription_id, annee_academique_id, date) SELECT id, promotion_concrete_id, utilisateur_id, etudiant_annee_academique_id, inscription_id, annee_academique_id, date FROM __temp__reinscription');
        $this->addSql('DROP TABLE __temp__reinscription');
        $this->addSql('CREATE INDEX IDX_503AD36FB00F076 ON reinscription (annee_academique_id)');
        $this->addSql('CREATE INDEX IDX_503AD36F5DAC5993 ON reinscription (inscription_id)');
        $this->addSql('CREATE INDEX IDX_503AD36FFD47D769 ON reinscription (etudiant_annee_academique_id)');
        $this->addSql('CREATE INDEX IDX_503AD36FFB88E14F ON reinscription (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_503AD36F2302286B ON reinscription (promotion_concrete_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_503AD36F2A4C4478 ON reinscription (paiement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__inscription AS SELECT id, promotion_concrete_id, etudiant_annee_academique_id, date, observation, matricule FROM inscription');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('CREATE TABLE inscription (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, promotion_concrete_id INTEGER NOT NULL, etudiant_annee_academique_id INTEGER NOT NULL, date DATETIME NOT NULL, observation VARCHAR(255) DEFAULT NULL, matricule VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_5E90F6D62302286B FOREIGN KEY (promotion_concrete_id) REFERENCES promotion_concrete (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5E90F6D6FD47D769 FOREIGN KEY (etudiant_annee_academique_id) REFERENCES etudiant_annee_academique (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO inscription (id, promotion_concrete_id, etudiant_annee_academique_id, date, observation, matricule) SELECT id, promotion_concrete_id, etudiant_annee_academique_id, date, observation, matricule FROM __temp__inscription');
        $this->addSql('DROP TABLE __temp__inscription');
        $this->addSql('CREATE INDEX IDX_5E90F6D62302286B ON inscription (promotion_concrete_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5E90F6D6FD47D769 ON inscription (etudiant_annee_academique_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__paiement AS SELECT id, frais_id, utilisateur_id, date_paiement FROM paiement');
        $this->addSql('DROP TABLE paiement');
        $this->addSql('CREATE TABLE paiement (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, frais_id INTEGER NOT NULL, utilisateur_id INTEGER NOT NULL, inscription_id INTEGER DEFAULT NULL, reinscription_id INTEGER DEFAULT NULL, date_paiement DATE NOT NULL, CONSTRAINT FK_B1DC7A1EBF516DC4 FOREIGN KEY (frais_id) REFERENCES frais (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B1DC7A1EFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B1DC7A1E5DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B1DC7A1E49D30613 FOREIGN KEY (reinscription_id) REFERENCES reinscription (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO paiement (id, frais_id, utilisateur_id, date_paiement) SELECT id, frais_id, utilisateur_id, date_paiement FROM __temp__paiement');
        $this->addSql('DROP TABLE __temp__paiement');
        $this->addSql('CREATE INDEX IDX_B1DC7A1EBF516DC4 ON paiement (frais_id)');
        $this->addSql('CREATE INDEX IDX_B1DC7A1EFB88E14F ON paiement (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_B1DC7A1E49D30613 ON paiement (reinscription_id)');
        $this->addSql('CREATE INDEX IDX_B1DC7A1E5DAC5993 ON paiement (inscription_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reinscription AS SELECT id, promotion_concrete_id, utilisateur_id, etudiant_annee_academique_id, inscription_id, annee_academique_id, date FROM reinscription');
        $this->addSql('DROP TABLE reinscription');
        $this->addSql('CREATE TABLE reinscription (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, promotion_concrete_id INTEGER NOT NULL, utilisateur_id INTEGER DEFAULT NULL, etudiant_annee_academique_id INTEGER NOT NULL, inscription_id INTEGER DEFAULT NULL, annee_academique_id INTEGER NOT NULL, date DATETIME NOT NULL, CONSTRAINT FK_503AD36F2302286B FOREIGN KEY (promotion_concrete_id) REFERENCES promotion_concrete (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_503AD36FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_503AD36FFD47D769 FOREIGN KEY (etudiant_annee_academique_id) REFERENCES etudiant_annee_academique (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_503AD36F5DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_503AD36FB00F076 FOREIGN KEY (annee_academique_id) REFERENCES annee_academique (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO reinscription (id, promotion_concrete_id, utilisateur_id, etudiant_annee_academique_id, inscription_id, annee_academique_id, date) SELECT id, promotion_concrete_id, utilisateur_id, etudiant_annee_academique_id, inscription_id, annee_academique_id, date FROM __temp__reinscription');
        $this->addSql('DROP TABLE __temp__reinscription');
        $this->addSql('CREATE INDEX IDX_503AD36F2302286B ON reinscription (promotion_concrete_id)');
        $this->addSql('CREATE INDEX IDX_503AD36FFB88E14F ON reinscription (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_503AD36FFD47D769 ON reinscription (etudiant_annee_academique_id)');
        $this->addSql('CREATE INDEX IDX_503AD36F5DAC5993 ON reinscription (inscription_id)');
        $this->addSql('CREATE INDEX IDX_503AD36FB00F076 ON reinscription (annee_academique_id)');
    }
}
