<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231214084305 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE casier (id INT AUTO_INCREMENT NOT NULL, le_centre_relais_colis_id INT DEFAULT NULL, volume INT NOT NULL, date_debut_reservation DATETIME NOT NULL, date_fin_reservation DATETIME NOT NULL, INDEX IDX_3FDF2857A443577 (le_centre_relais_colis_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE centre_relais_colis (id INT AUTO_INCREMENT NOT NULL, ville_id INT DEFAULT NULL, adresse VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_A7CFF39EA73F0036 (ville_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE colis (id INT AUTO_INCREMENT NOT NULL, la_commande_id INT DEFAULT NULL, casier_id INT DEFAULT NULL, etat_id INT DEFAULT NULL, volume INT NOT NULL, poids INT NOT NULL, INDEX IDX_470BDFF93743EDD (la_commande_id), INDEX IDX_470BDFF9643911C6 (casier_id), INDEX IDX_470BDFF9D5E86FF (etat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, le_compte_utilisateur_id INT DEFAULT NULL, la_ville_id INT DEFAULT NULL, le_pays_id INT DEFAULT NULL, localisation_id INT DEFAULT NULL, prenom_acheteur VARCHAR(255) NOT NULL, nom_acheteur VARCHAR(255) NOT NULL, volume INT NOT NULL, poids INT NOT NULL, date_livraison DATETIME NOT NULL, etat VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, numero_telephone VARCHAR(255) NOT NULL, numero_suivi VARCHAR(13) NOT NULL, date_localisation DATETIME NOT NULL, INDEX IDX_6EEAA67D9906B190 (le_compte_utilisateur_id), INDEX IDX_6EEAA67D609A8BA5 (la_ville_id), INDEX IDX_6EEAA67D892B3433 (le_pays_id), INDEX IDX_6EEAA67DC68BE09C (localisation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_casier (commande_id INT NOT NULL, casier_id INT NOT NULL, INDEX IDX_1A9095082EA2E54 (commande_id), INDEX IDX_1A90950643911C6 (casier_id), PRIMARY KEY(commande_id, casier_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compte_utilisateur (id INT AUTO_INCREMENT NOT NULL, le_type_notification_id INT NOT NULL, le_centre_relais_colis_defaut_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_register TINYINT(1) NOT NULL, register_number INT NOT NULL, register_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_310DE9E7E7927C74 (email), INDEX IDX_310DE9E798D9D7D3 (le_type_notification_id), INDEX IDX_310DE9E713A11F0B (le_centre_relais_colis_defaut_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etat (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE localisation (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, le_compte_utilisateur_id INT DEFAULT NULL, le_type_notification_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, date DATETIME NOT NULL, INDEX IDX_BF5476CA9906B190 (le_compte_utilisateur_id), INDEX IDX_BF5476CA98D9D7D3 (le_type_notification_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pays (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_notification (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ville (id INT AUTO_INCREMENT NOT NULL, le_pays_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, code_postal INT NOT NULL, INDEX IDX_43C3D9C3892B3433 (le_pays_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE casier ADD CONSTRAINT FK_3FDF2857A443577 FOREIGN KEY (le_centre_relais_colis_id) REFERENCES centre_relais_colis (id)');
        $this->addSql('ALTER TABLE centre_relais_colis ADD CONSTRAINT FK_A7CFF39EA73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');
        $this->addSql('ALTER TABLE colis ADD CONSTRAINT FK_470BDFF93743EDD FOREIGN KEY (la_commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE colis ADD CONSTRAINT FK_470BDFF9643911C6 FOREIGN KEY (casier_id) REFERENCES casier (id)');
        $this->addSql('ALTER TABLE colis ADD CONSTRAINT FK_470BDFF9D5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D9906B190 FOREIGN KEY (le_compte_utilisateur_id) REFERENCES compte_utilisateur (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D609A8BA5 FOREIGN KEY (la_ville_id) REFERENCES ville (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D892B3433 FOREIGN KEY (le_pays_id) REFERENCES pays (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DC68BE09C FOREIGN KEY (localisation_id) REFERENCES localisation (id)');
        $this->addSql('ALTER TABLE commande_casier ADD CONSTRAINT FK_1A9095082EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_casier ADD CONSTRAINT FK_1A90950643911C6 FOREIGN KEY (casier_id) REFERENCES casier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE compte_utilisateur ADD CONSTRAINT FK_310DE9E798D9D7D3 FOREIGN KEY (le_type_notification_id) REFERENCES type_notification (id)');
        $this->addSql('ALTER TABLE compte_utilisateur ADD CONSTRAINT FK_310DE9E713A11F0B FOREIGN KEY (le_centre_relais_colis_defaut_id) REFERENCES centre_relais_colis (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA9906B190 FOREIGN KEY (le_compte_utilisateur_id) REFERENCES compte_utilisateur (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA98D9D7D3 FOREIGN KEY (le_type_notification_id) REFERENCES type_notification (id)');
        $this->addSql('ALTER TABLE ville ADD CONSTRAINT FK_43C3D9C3892B3433 FOREIGN KEY (le_pays_id) REFERENCES pays (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE casier DROP FOREIGN KEY FK_3FDF2857A443577');
        $this->addSql('ALTER TABLE centre_relais_colis DROP FOREIGN KEY FK_A7CFF39EA73F0036');
        $this->addSql('ALTER TABLE colis DROP FOREIGN KEY FK_470BDFF93743EDD');
        $this->addSql('ALTER TABLE colis DROP FOREIGN KEY FK_470BDFF9643911C6');
        $this->addSql('ALTER TABLE colis DROP FOREIGN KEY FK_470BDFF9D5E86FF');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D9906B190');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D609A8BA5');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D892B3433');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DC68BE09C');
        $this->addSql('ALTER TABLE commande_casier DROP FOREIGN KEY FK_1A9095082EA2E54');
        $this->addSql('ALTER TABLE commande_casier DROP FOREIGN KEY FK_1A90950643911C6');
        $this->addSql('ALTER TABLE compte_utilisateur DROP FOREIGN KEY FK_310DE9E798D9D7D3');
        $this->addSql('ALTER TABLE compte_utilisateur DROP FOREIGN KEY FK_310DE9E713A11F0B');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA9906B190');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA98D9D7D3');
        $this->addSql('ALTER TABLE ville DROP FOREIGN KEY FK_43C3D9C3892B3433');
        $this->addSql('DROP TABLE casier');
        $this->addSql('DROP TABLE centre_relais_colis');
        $this->addSql('DROP TABLE colis');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE commande_casier');
        $this->addSql('DROP TABLE compte_utilisateur');
        $this->addSql('DROP TABLE etat');
        $this->addSql('DROP TABLE localisation');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE pays');
        $this->addSql('DROP TABLE type_notification');
        $this->addSql('DROP TABLE ville');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
