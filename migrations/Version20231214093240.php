<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231214093240 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE localisation_colis (id INT AUTO_INCREMENT NOT NULL, le_colis_id INT DEFAULT NULL, la_localisation_id INT DEFAULT NULL, la_commande_id INT DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_8E136C888368A699 (le_colis_id), INDEX IDX_8E136C883F81AE7F (la_localisation_id), INDEX IDX_8E136C883743EDD (la_commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE localisation_colis ADD CONSTRAINT FK_8E136C888368A699 FOREIGN KEY (le_colis_id) REFERENCES colis (id)');
        $this->addSql('ALTER TABLE localisation_colis ADD CONSTRAINT FK_8E136C883F81AE7F FOREIGN KEY (la_localisation_id) REFERENCES localisation (id)');
        $this->addSql('ALTER TABLE localisation_colis ADD CONSTRAINT FK_8E136C883743EDD FOREIGN KEY (la_commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DC68BE09C');
        $this->addSql('DROP INDEX IDX_6EEAA67DC68BE09C ON commande');
        $this->addSql('ALTER TABLE commande DROP localisation_id, DROP date_localisation');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE localisation_colis DROP FOREIGN KEY FK_8E136C888368A699');
        $this->addSql('ALTER TABLE localisation_colis DROP FOREIGN KEY FK_8E136C883F81AE7F');
        $this->addSql('ALTER TABLE localisation_colis DROP FOREIGN KEY FK_8E136C883743EDD');
        $this->addSql('DROP TABLE localisation_colis');
        $this->addSql('ALTER TABLE commande ADD localisation_id INT DEFAULT NULL, ADD date_localisation DATETIME NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DC68BE09C FOREIGN KEY (localisation_id) REFERENCES localisation (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67DC68BE09C ON commande (localisation_id)');
    }
}
