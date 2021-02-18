<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210209094422 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE opponent_car (id INT AUTO_INCREMENT NOT NULL, license_plate VARCHAR(255) DEFAULT NULL, manufacturer VARCHAR(255) DEFAULT NULL, model VARCHAR(255) DEFAULT NULL, year_of_manufacture VARCHAR(255) DEFAULT NULL, km_status INT DEFAULT NULL, insured_with VARCHAR(255) DEFAULT NULL, insurance_number VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car ADD opponent_car_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DE576C015 FOREIGN KEY (opponent_car_id) REFERENCES opponent_car (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_773DE69DE576C015 ON car (opponent_car_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DE576C015');
        $this->addSql('DROP TABLE opponent_car');
        $this->addSql('DROP INDEX UNIQ_773DE69DE576C015 ON car');
        $this->addSql('ALTER TABLE car DROP opponent_car_id');
    }
}
