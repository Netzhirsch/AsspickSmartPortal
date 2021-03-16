<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210316132142 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE theft_protection_typ DROP FOREIGN KEY FK_1B516906C3C6F69F');
        $this->addSql('DROP INDEX IDX_1B516906C3C6F69F ON theft_protection_typ');
        $this->addSql('ALTER TABLE theft_protection_typ DROP car_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE theft_protection_typ ADD car_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE theft_protection_typ ADD CONSTRAINT FK_1B516906C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('CREATE INDEX IDX_1B516906C3C6F69F ON theft_protection_typ (car_id)');
    }
}
