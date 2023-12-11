<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231211125646 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD la_ville_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D609A8BA5 FOREIGN KEY (la_ville_id) REFERENCES ville (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D609A8BA5 ON commande (la_ville_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D609A8BA5');
        $this->addSql('DROP INDEX IDX_6EEAA67D609A8BA5 ON commande');
        $this->addSql('ALTER TABLE commande DROP la_ville_id');
    }
}
