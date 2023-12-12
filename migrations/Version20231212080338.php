<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231212080338 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, le_compte_utilisateur_id INT DEFAULT NULL, le_type_notification_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, date DATETIME NOT NULL, INDEX IDX_BF5476CA9906B190 (le_compte_utilisateur_id), INDEX IDX_BF5476CA98D9D7D3 (le_type_notification_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA9906B190 FOREIGN KEY (le_compte_utilisateur_id) REFERENCES compte_utilisateur (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA98D9D7D3 FOREIGN KEY (le_type_notification_id) REFERENCES type_notification (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA9906B190');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA98D9D7D3');
        $this->addSql('DROP TABLE notification');
    }
}
