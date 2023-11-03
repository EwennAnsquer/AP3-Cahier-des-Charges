<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231103200137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande_casier (commande_id INT NOT NULL, casier_id INT NOT NULL, INDEX IDX_1A9095082EA2E54 (commande_id), INDEX IDX_1A90950643911C6 (casier_id), PRIMARY KEY(commande_id, casier_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande_casier ADD CONSTRAINT FK_1A9095082EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_casier ADD CONSTRAINT FK_1A90950643911C6 FOREIGN KEY (casier_id) REFERENCES casier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DBD210531');
        $this->addSql('DROP INDEX UNIQ_6EEAA67DBD210531 ON commande');
        $this->addSql('ALTER TABLE commande DROP le_casier_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande_casier DROP FOREIGN KEY FK_1A9095082EA2E54');
        $this->addSql('ALTER TABLE commande_casier DROP FOREIGN KEY FK_1A90950643911C6');
        $this->addSql('DROP TABLE commande_casier');
        $this->addSql('ALTER TABLE commande ADD le_casier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DBD210531 FOREIGN KEY (le_casier_id) REFERENCES casier (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6EEAA67DBD210531 ON commande (le_casier_id)');
    }
}
