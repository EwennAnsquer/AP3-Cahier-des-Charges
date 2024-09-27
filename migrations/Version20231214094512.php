<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231214094512 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE localisation_colis DROP FOREIGN KEY FK_8E136C888368A699');
        $this->addSql('DROP INDEX IDX_8E136C888368A699 ON localisation_colis');
        $this->addSql('ALTER TABLE localisation_colis DROP le_colis_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE localisation_colis ADD le_colis_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE localisation_colis ADD CONSTRAINT FK_8E136C888368A699 FOREIGN KEY (le_colis_id) REFERENCES colis (id)');
        $this->addSql('CREATE INDEX IDX_8E136C888368A699 ON localisation_colis (le_colis_id)');
    }
}
