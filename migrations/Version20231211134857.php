<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231211134857 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ville ADD le_pays_id INT DEFAULT NULL, DROP pays');
        $this->addSql('ALTER TABLE ville ADD CONSTRAINT FK_43C3D9C3892B3433 FOREIGN KEY (le_pays_id) REFERENCES pays (id)');
        $this->addSql('CREATE INDEX IDX_43C3D9C3892B3433 ON ville (le_pays_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ville DROP FOREIGN KEY FK_43C3D9C3892B3433');
        $this->addSql('DROP INDEX IDX_43C3D9C3892B3433 ON ville');
        $this->addSql('ALTER TABLE ville ADD pays VARCHAR(255) NOT NULL, DROP le_pays_id');
    }
}
