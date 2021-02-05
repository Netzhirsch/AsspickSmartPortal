<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210204132436 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE claimant (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, street_mailbox VARCHAR(255) NOT NULL, post_code VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE criminal_proceedings_against_typ (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE liability ADD criminal_proceedings_against_typ_id INT DEFAULT NULL, ADD has_criminal_proceedings TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE liability ADD CONSTRAINT FK_3B59ECCC8CB61D50 FOREIGN KEY (criminal_proceedings_against_typ_id) REFERENCES criminal_proceedings_against_typ (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3B59ECCC8CB61D50 ON liability (criminal_proceedings_against_typ_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liability DROP FOREIGN KEY FK_3B59ECCC8CB61D50');
        $this->addSql('DROP TABLE claimant');
        $this->addSql('DROP TABLE criminal_proceedings_against_typ');
        $this->addSql('DROP INDEX UNIQ_3B59ECCC8CB61D50 ON liability');
        $this->addSql('ALTER TABLE liability DROP criminal_proceedings_against_typ_id, DROP has_criminal_proceedings');
    }
}
