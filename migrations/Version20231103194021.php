<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231103194021 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE casier (id INT AUTO_INCREMENT NOT NULL, le_centre_relais_colis_id INT DEFAULT NULL, volume INT NOT NULL, date_debut_reservation DATETIME NOT NULL, date_fin_reservation DATETIME NOT NULL, INDEX IDX_3FDF2857A443577 (le_centre_relais_colis_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE centre_relais_colis (id INT AUTO_INCREMENT NOT NULL, adresse VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, code_postal INT NOT NULL, pays VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE colis (id INT AUTO_INCREMENT NOT NULL, la_commande_id INT DEFAULT NULL, etat VARCHAR(255) NOT NULL, volume INT NOT NULL, poids INT NOT NULL, INDEX IDX_470BDFF93743EDD (la_commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, le_casier_id INT DEFAULT NULL, le_compte_utilisateur_id INT DEFAULT NULL, pays VARCHAR(255) NOT NULL, prenom_acheteur VARCHAR(255) NOT NULL, nom_acheteur VARCHAR(255) NOT NULL, code_postal INT NOT NULL, ville VARCHAR(255) NOT NULL, numero_telephone INT NOT NULL, volume INT NOT NULL, poids INT NOT NULL, date_livraison DATETIME NOT NULL, etat VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_6EEAA67DBD210531 (le_casier_id), INDEX IDX_6EEAA67D9906B190 (le_compte_utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compte_utilisateur (id INT AUTO_INCREMENT NOT NULL, adresse_mail VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE casier ADD CONSTRAINT FK_3FDF2857A443577 FOREIGN KEY (le_centre_relais_colis_id) REFERENCES centre_relais_colis (id)');
        $this->addSql('ALTER TABLE colis ADD CONSTRAINT FK_470BDFF93743EDD FOREIGN KEY (la_commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DBD210531 FOREIGN KEY (le_casier_id) REFERENCES casier (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D9906B190 FOREIGN KEY (le_compte_utilisateur_id) REFERENCES compte_utilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE casier DROP FOREIGN KEY FK_3FDF2857A443577');
        $this->addSql('ALTER TABLE colis DROP FOREIGN KEY FK_470BDFF93743EDD');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DBD210531');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D9906B190');
        $this->addSql('DROP TABLE casier');
        $this->addSql('DROP TABLE centre_relais_colis');
        $this->addSql('DROP TABLE colis');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE compte_utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
