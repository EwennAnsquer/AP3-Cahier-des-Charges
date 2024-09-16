<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231212080930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE colis ADD casier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE colis ADD CONSTRAINT FK_470BDFF9643911C6 FOREIGN KEY (casier_id) REFERENCES casier (id)');
        $this->addSql('CREATE INDEX IDX_470BDFF9643911C6 ON colis (casier_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE colis DROP FOREIGN KEY FK_470BDFF9643911C6');
        $this->addSql('DROP INDEX IDX_470BDFF9643911C6 ON colis');
        $this->addSql('ALTER TABLE colis DROP casier_id');
    }
}
