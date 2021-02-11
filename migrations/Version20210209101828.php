<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210209101828 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE damage_caused_by (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE damage_typ (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE damage_event ADD caused_by_id INT DEFAULT NULL, ADD number_of_vehicles_involved INT DEFAULT NULL, ADD damage_amount_on_opponent NUMERIC(10, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE damage_event ADD CONSTRAINT FK_AD2E4FBF1AE22BB1 FOREIGN KEY (caused_by_id) REFERENCES damage_caused_by (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AD2E4FBF1AE22BB1 ON damage_event (caused_by_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE damage_event DROP FOREIGN KEY FK_AD2E4FBF1AE22BB1');
        $this->addSql('DROP TABLE damage_caused_by');
        $this->addSql('DROP TABLE damage_typ');
        $this->addSql('DROP INDEX UNIQ_AD2E4FBF1AE22BB1 ON damage_event');
        $this->addSql('ALTER TABLE damage_event DROP caused_by_id, DROP number_of_vehicles_involved, DROP damage_amount_on_opponent');
    }
}
