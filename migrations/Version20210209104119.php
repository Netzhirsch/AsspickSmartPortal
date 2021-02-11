<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210209104119 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE theft_protection_typ (id INT AUTO_INCREMENT NOT NULL, car_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_1B516906C3C6F69F (car_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE theft_protection_typ ADD CONSTRAINT FK_1B516906C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('ALTER TABLE car ADD type_of_injury VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
//        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE theft_protection_typ');
        $this->addSql('ALTER TABLE car DROP type_of_injury');
    }
}
