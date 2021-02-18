<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210209131816 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE car_theft_protection_typ (car_id INT NOT NULL, theft_protection_typ_id INT NOT NULL, INDEX IDX_9D6B88C6C3C6F69F (car_id), INDEX IDX_9D6B88C6CA9F0815 (theft_protection_typ_id), PRIMARY KEY(car_id, theft_protection_typ_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car_theft_protection_typ ADD CONSTRAINT FK_9D6B88C6C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE car_theft_protection_typ ADD CONSTRAINT FK_9D6B88C6CA9F0815 FOREIGN KEY (theft_protection_typ_id) REFERENCES theft_protection_typ (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE car_theft_protection_typ');
    }
}
