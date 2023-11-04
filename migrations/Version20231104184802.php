<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231104184802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD le_compte_utilisateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D9906B190 FOREIGN KEY (le_compte_utilisateur_id) REFERENCES compte_utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D9906B190 ON commande (le_compte_utilisateur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D9906B190');
        $this->addSql('DROP INDEX IDX_6EEAA67D9906B190 ON commande');
        $this->addSql('ALTER TABLE commande DROP le_compte_utilisateur_id');
    }
}
