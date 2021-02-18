<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210204125552 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE damage_cause (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, street_mailbox VARCHAR(255) NOT NULL, postcode VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, date_of_birth DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE damage_event (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, time TIME NOT NULL, location VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE insured (id INT AUTO_INCREMENT NOT NULL, insured VARCHAR(255) NOT NULL, insurance_number VARCHAR(255) DEFAULT NULL, danger_number VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liability (id INT AUTO_INCREMENT NOT NULL, insured_id INT NOT NULL, policyholder_id INT NOT NULL, damage_event_id INT NOT NULL, damage_cause_id INT DEFAULT NULL, witness_id INT DEFAULT NULL, police_recording_id INT NOT NULL, UNIQUE INDEX UNIQ_3B59ECCCFC2A5C84 (insured_id), UNIQUE INDEX UNIQ_3B59ECCCD1F9FFBD (policyholder_id), UNIQUE INDEX UNIQ_3B59ECCC37422B5 (damage_event_id), UNIQUE INDEX UNIQ_3B59ECCC1461E820 (damage_cause_id), UNIQUE INDEX UNIQ_3B59ECCCF28D7E1C (witness_id), UNIQUE INDEX UNIQ_3B59ECCC330EFAD7 (police_recording_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE police_recording (id INT AUTO_INCREMENT NOT NULL, is_recorded TINYINT(1) NOT NULL, department LONGTEXT DEFAULT NULL, file_reference VARCHAR(255) DEFAULT NULL, diary_number VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE policyholder (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, street_mailbox VARCHAR(255) NOT NULL, post_code VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE witness (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, street_mailbox VARCHAR(255) NOT NULL, postcode VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE liability ADD CONSTRAINT FK_3B59ECCCFC2A5C84 FOREIGN KEY (insured_id) REFERENCES insured (id)');
        $this->addSql('ALTER TABLE liability ADD CONSTRAINT FK_3B59ECCCD1F9FFBD FOREIGN KEY (policyholder_id) REFERENCES policyholder (id)');
        $this->addSql('ALTER TABLE liability ADD CONSTRAINT FK_3B59ECCC37422B5 FOREIGN KEY (damage_event_id) REFERENCES damage_event (id)');
        $this->addSql('ALTER TABLE liability ADD CONSTRAINT FK_3B59ECCC1461E820 FOREIGN KEY (damage_cause_id) REFERENCES damage_cause (id)');
        $this->addSql('ALTER TABLE liability ADD CONSTRAINT FK_3B59ECCCF28D7E1C FOREIGN KEY (witness_id) REFERENCES witness (id)');
        $this->addSql('ALTER TABLE liability ADD CONSTRAINT FK_3B59ECCC330EFAD7 FOREIGN KEY (police_recording_id) REFERENCES police_recording (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liability DROP FOREIGN KEY FK_3B59ECCC1461E820');
        $this->addSql('ALTER TABLE liability DROP FOREIGN KEY FK_3B59ECCC37422B5');
        $this->addSql('ALTER TABLE liability DROP FOREIGN KEY FK_3B59ECCCFC2A5C84');
        $this->addSql('ALTER TABLE liability DROP FOREIGN KEY FK_3B59ECCC330EFAD7');
        $this->addSql('ALTER TABLE liability DROP FOREIGN KEY FK_3B59ECCCD1F9FFBD');
        $this->addSql('ALTER TABLE liability DROP FOREIGN KEY FK_3B59ECCCF28D7E1C');
        $this->addSql('DROP TABLE damage_cause');
        $this->addSql('DROP TABLE damage_event');
        $this->addSql('DROP TABLE insured');
        $this->addSql('DROP TABLE liability');
        $this->addSql('DROP TABLE police_recording');
        $this->addSql('DROP TABLE policyholder');
        $this->addSql('DROP TABLE witness');
    }
}
