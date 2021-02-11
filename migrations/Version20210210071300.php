<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210210071300 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE payment_transfer_to_typ (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE payment ADD transfer_to_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D93B1BF3D FOREIGN KEY (transfer_to_id) REFERENCES payment_transfer_to_typ (id)');
        $this->addSql('CREATE INDEX IDX_6D28840D93B1BF3D ON payment (transfer_to_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D93B1BF3D');
        $this->addSql('DROP TABLE payment_transfer_to_typ');
        $this->addSql('DROP INDEX IDX_6D28840D93B1BF3D ON payment');
        $this->addSql('ALTER TABLE payment DROP transfer_to_id');
    }
}
