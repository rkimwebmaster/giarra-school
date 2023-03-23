<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230323143107 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresse (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, adresse VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, pays VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE annee_academique (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, debut INTEGER NOT NULL, fin INTEGER NOT NULL, is_en_cours BOOLEAN NOT NULL, is_passe BOOLEAN NOT NULL, grand_total_frais DOUBLE PRECISION DEFAULT NULL)');
        $this->addSql('CREATE TABLE departement (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, faculte_section_id INTEGER NOT NULL, designation VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, CONSTRAINT FK_C1765B63E3C6CB67 FOREIGN KEY (faculte_section_id) REFERENCES faculte_section (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_C1765B63E3C6CB67 ON departement (faculte_section_id)');
        $this->addSql('CREATE TABLE entreprise (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, adresse_id INTEGER NOT NULL, annee_academique_id INTEGER NOT NULL, nom VARCHAR(255) NOT NULL, devise VARCHAR(255) NOT NULL, CONSTRAINT FK_D19FA604DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D19FA60B00F076 FOREIGN KEY (annee_academique_id) REFERENCES annee_academique (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D19FA604DE7DC5C ON entreprise (adresse_id)');
        $this->addSql('CREATE INDEX IDX_D19FA60B00F076 ON entreprise (annee_academique_id)');
        $this->addSql('CREATE TABLE etudiant_annee_academique (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, identite_id INTEGER NOT NULL, adresse_id INTEGER DEFAULT NULL, promotion_actuelle_id INTEGER NOT NULL, inscription_id INTEGER NOT NULL, matricule VARCHAR(255) NOT NULL, telephone_tuteur VARCHAR(255) NOT NULL, has_reussie BOOLEAN NOT NULL, genre VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_9975628AE5F13C8F FOREIGN KEY (identite_id) REFERENCES identite (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9975628A4DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9975628A378EAEAC FOREIGN KEY (promotion_actuelle_id) REFERENCES promotion_concrete (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9975628A5DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_9975628AE5F13C8F ON etudiant_annee_academique (identite_id)');
        $this->addSql('CREATE INDEX IDX_9975628A4DE7DC5C ON etudiant_annee_academique (adresse_id)');
        $this->addSql('CREATE INDEX IDX_9975628A378EAEAC ON etudiant_annee_academique (promotion_actuelle_id)');
        $this->addSql('CREATE INDEX IDX_9975628A5DAC5993 ON etudiant_annee_academique (inscription_id)');
        $this->addSql('CREATE TABLE faculte_section (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, designation VARCHAR(255) NOT NULL, text VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_26941DD08947610D ON faculte_section (designation)');
        $this->addSql('CREATE TABLE frais (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, frais_abstrait_id INTEGER NOT NULL, annee_academique_id INTEGER NOT NULL, date_butoire DATE NOT NULL, montant DOUBLE PRECISION NOT NULL, total_perception DOUBLE PRECISION DEFAULT NULL, CONSTRAINT FK_25404C98213B6273 FOREIGN KEY (frais_abstrait_id) REFERENCES frais_abstrait (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_25404C98B00F076 FOREIGN KEY (annee_academique_id) REFERENCES annee_academique (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_25404C98213B6273 ON frais (frais_abstrait_id)');
        $this->addSql('CREATE INDEX IDX_25404C98B00F076 ON frais (annee_academique_id)');
        $this->addSql('CREATE TABLE frais_abstrait (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, designation VARCHAR(180) NOT NULL, description CLOB DEFAULT NULL, is_inscription BOOLEAN NOT NULL, is_reinscription BOOLEAN NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BD0F24338947610D ON frais_abstrait (designation)');
        $this->addSql('CREATE TABLE identite (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, postnom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE inscription (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, promotion_concrete_id INTEGER NOT NULL, utilisateur_id INTEGER NOT NULL, premier_etudiant_annee_academique_id INTEGER DEFAULT NULL, paiement_id INTEGER NOT NULL, date DATETIME NOT NULL, observation VARCHAR(255) DEFAULT NULL, matricule VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_5E90F6D62302286B FOREIGN KEY (promotion_concrete_id) REFERENCES promotion_concrete (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5E90F6D6FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5E90F6D6C2C6E7E2 FOREIGN KEY (premier_etudiant_annee_academique_id) REFERENCES etudiant_annee_academique (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5E90F6D62A4C4478 FOREIGN KEY (paiement_id) REFERENCES paiement (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_5E90F6D62302286B ON inscription (promotion_concrete_id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D6FB88E14F ON inscription (utilisateur_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5E90F6D6C2C6E7E2 ON inscription (premier_etudiant_annee_academique_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5E90F6D62A4C4478 ON inscription (paiement_id)');
        $this->addSql('CREATE TABLE notification (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, utilisateur_id INTEGER NOT NULL, date DATETIME NOT NULL, sujet VARCHAR(255) NOT NULL, message VARCHAR(255) NOT NULL, is_lu BOOLEAN NOT NULL, CONSTRAINT FK_BF5476CAFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_BF5476CAFB88E14F ON notification (utilisateur_id)');
        $this->addSql('CREATE TABLE paiement (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, frais_id INTEGER NOT NULL, utilisateur_id INTEGER NOT NULL, etudiant_annee_academique_id INTEGER DEFAULT NULL, date_paiement DATE NOT NULL, CONSTRAINT FK_B1DC7A1EBF516DC4 FOREIGN KEY (frais_id) REFERENCES frais (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B1DC7A1EFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B1DC7A1EFD47D769 FOREIGN KEY (etudiant_annee_academique_id) REFERENCES etudiant_annee_academique (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_B1DC7A1EBF516DC4 ON paiement (frais_id)');
        $this->addSql('CREATE INDEX IDX_B1DC7A1EFB88E14F ON paiement (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_B1DC7A1EFD47D769 ON paiement (etudiant_annee_academique_id)');
        $this->addSql('CREATE TABLE promotion_abstraite (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, departement_id INTEGER NOT NULL, designation VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, CONSTRAINT FK_329E8880CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_329E8880CCF9E01E ON promotion_abstraite (departement_id)');
        $this->addSql('CREATE TABLE promotion_concrete (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, promotion_abstraite_id INTEGER NOT NULL, annnee_academique_id INTEGER NOT NULL, specification VARCHAR(1) NOT NULL, CONSTRAINT FK_9521CB3763997282 FOREIGN KEY (promotion_abstraite_id) REFERENCES promotion_abstraite (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9521CB37D721FF01 FOREIGN KEY (annnee_academique_id) REFERENCES annee_academique (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_9521CB3763997282 ON promotion_concrete (promotion_abstraite_id)');
        $this->addSql('CREATE INDEX IDX_9521CB37D721FF01 ON promotion_concrete (annnee_academique_id)');
        $this->addSql('CREATE TABLE reinscription (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, promotion_concrete_id INTEGER NOT NULL, utilisateur_id INTEGER DEFAULT NULL, etudiant_annee_academique_id INTEGER NOT NULL, inscription_id INTEGER DEFAULT NULL, annee_academique_id INTEGER NOT NULL, paiement_id INTEGER NOT NULL, date DATETIME NOT NULL, CONSTRAINT FK_503AD36F2302286B FOREIGN KEY (promotion_concrete_id) REFERENCES promotion_concrete (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_503AD36FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_503AD36FFD47D769 FOREIGN KEY (etudiant_annee_academique_id) REFERENCES etudiant_annee_academique (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_503AD36F5DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_503AD36FB00F076 FOREIGN KEY (annee_academique_id) REFERENCES annee_academique (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_503AD36F2A4C4478 FOREIGN KEY (paiement_id) REFERENCES paiement (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_503AD36F2302286B ON reinscription (promotion_concrete_id)');
        $this->addSql('CREATE INDEX IDX_503AD36FFB88E14F ON reinscription (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_503AD36FFD47D769 ON reinscription (etudiant_annee_academique_id)');
        $this->addSql('CREATE INDEX IDX_503AD36F5DAC5993 ON reinscription (inscription_id)');
        $this->addSql('CREATE INDEX IDX_503AD36FB00F076 ON reinscription (annee_academique_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_503AD36F2A4C4478 ON reinscription (paiement_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, notification_non_lu INTEGER NOT NULL, role_principal VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP TABLE annee_academique');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE etudiant_annee_academique');
        $this->addSql('DROP TABLE faculte_section');
        $this->addSql('DROP TABLE frais');
        $this->addSql('DROP TABLE frais_abstrait');
        $this->addSql('DROP TABLE identite');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE paiement');
        $this->addSql('DROP TABLE promotion_abstraite');
        $this->addSql('DROP TABLE promotion_concrete');
        $this->addSql('DROP TABLE reinscription');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
