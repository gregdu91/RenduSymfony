<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200322191622 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE panier ADD qte VARCHAR(255) DEFAULT NULL, DROP quantit, CHANGE produit_id produit_id INT DEFAULT NULL, CHANGE date date DATETIME DEFAULT NULL, CHANGE etat etat TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD qte VARCHAR(255) DEFAULT NULL, DROP quantit, CHANGE photo photo VARCHAR(255) DEFAULT NULL, CHANGE prix prix VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE panier ADD quantit VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP qte, CHANGE produit_id produit_id INT NOT NULL, CHANGE date date DATETIME NOT NULL, CHANGE etat etat TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE produit ADD quantit VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP qte, CHANGE photo photo VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prix prix VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
