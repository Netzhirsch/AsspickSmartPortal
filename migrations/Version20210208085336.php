<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210208085336 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, typ_of_insurance_id INT NOT NULL, typ_of_trip_id INT NOT NULL, insured_id INT NOT NULL, policyholder_id INT NOT NULL, damage_event_id INT NOT NULL, INDEX IDX_773DE69DBEA2D228 (typ_of_insurance_id), INDEX IDX_773DE69D6B562C2A (typ_of_trip_id), UNIQUE INDEX UNIQ_773DE69DFC2A5C84 (insured_id), UNIQUE INDEX UNIQ_773DE69DD1F9FFBD (policyholder_id), UNIQUE INDEX UNIQ_773DE69D37422B5 (damage_event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE driver (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, street_mailbox VARCHAR(255) NOT NULL, post_code VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, has_license TINYINT(1) NOT NULL, license_class VARCHAR(255) NOT NULL, license_number VARCHAR(255) NOT NULL, date_of_issue DATE NOT NULL, exhibition_location VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE typ_of_insurance (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE typ_of_trip (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DBEA2D228 FOREIGN KEY (typ_of_insurance_id) REFERENCES typ_of_insurance (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D6B562C2A FOREIGN KEY (typ_of_trip_id) REFERENCES typ_of_trip (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DFC2A5C84 FOREIGN KEY (insured_id) REFERENCES insured (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DD1F9FFBD FOREIGN KEY (policyholder_id) REFERENCES policyholder (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D37422B5 FOREIGN KEY (damage_event_id) REFERENCES damage_event (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DBEA2D228');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D6B562C2A');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE driver');
        $this->addSql('DROP TABLE typ_of_insurance');
        $this->addSql('DROP TABLE typ_of_trip');
    }
}
