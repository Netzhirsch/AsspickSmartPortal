<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210210101701 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE building_damage (id INT AUTO_INCREMENT NOT NULL, relationship_to_building_id INT DEFAULT NULL, is_damage_in_rented_rooms TINYINT(1) DEFAULT NULL, tenant_firstname VARCHAR(255) DEFAULT NULL, tenant_lastname VARCHAR(255) DEFAULT NULL, home_insurer VARCHAR(255) DEFAULT NULL, home_insurer_number VARCHAR(255) DEFAULT NULL, INDEX IDX_17E8E87F91F1A5F (relationship_to_building_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cause_of_damage_typ (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE damage_event_cause_of_damage_typ (damage_event_id INT NOT NULL, cause_of_damage_typ_id INT NOT NULL, INDEX IDX_FB40E54337422B5 (damage_event_id), INDEX IDX_FB40E5432F50662 (cause_of_damage_typ_id), PRIMARY KEY(damage_event_id, cause_of_damage_typ_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE relationship_to_building (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repair_company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, street_mailbox VARCHAR(255) DEFAULT NULL, post_code VARCHAR(255) DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trace_of_break_in (id INT AUTO_INCREMENT NOT NULL, is_trace_present TINYINT(1) DEFAULT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE building_damage ADD CONSTRAINT FK_17E8E87F91F1A5F FOREIGN KEY (relationship_to_building_id) REFERENCES relationship_to_building (id)');
        $this->addSql('ALTER TABLE damage_event_cause_of_damage_typ ADD CONSTRAINT FK_FB40E54337422B5 FOREIGN KEY (damage_event_id) REFERENCES damage_event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE damage_event_cause_of_damage_typ ADD CONSTRAINT FK_FB40E5432F50662 FOREIGN KEY (cause_of_damage_typ_id) REFERENCES cause_of_damage_typ (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE general_damage ADD repair_company_id INT DEFAULT NULL, ADD police_recording_id INT DEFAULT NULL, ADD has_items_other_insurance TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE general_damage ADD CONSTRAINT FK_80E0A928F3B1DFF4 FOREIGN KEY (repair_company_id) REFERENCES repair_company (id)');
        $this->addSql('ALTER TABLE general_damage ADD CONSTRAINT FK_80E0A928330EFAD7 FOREIGN KEY (police_recording_id) REFERENCES police_recording (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_80E0A928F3B1DFF4 ON general_damage (repair_company_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_80E0A928330EFAD7 ON general_damage (police_recording_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE damage_event_cause_of_damage_typ DROP FOREIGN KEY FK_FB40E5432F50662');
        $this->addSql('ALTER TABLE building_damage DROP FOREIGN KEY FK_17E8E87F91F1A5F');
        $this->addSql('ALTER TABLE general_damage DROP FOREIGN KEY FK_80E0A928F3B1DFF4');
        $this->addSql('DROP TABLE building_damage');
        $this->addSql('DROP TABLE cause_of_damage_typ');
        $this->addSql('DROP TABLE damage_event_cause_of_damage_typ');
        $this->addSql('DROP TABLE relationship_to_building');
        $this->addSql('DROP TABLE repair_company');
        $this->addSql('DROP TABLE trace_of_break_in');
        $this->addSql('ALTER TABLE general_damage DROP FOREIGN KEY FK_80E0A928330EFAD7');
        $this->addSql('DROP INDEX UNIQ_80E0A928F3B1DFF4 ON general_damage');
        $this->addSql('DROP INDEX UNIQ_80E0A928330EFAD7 ON general_damage');
        $this->addSql('ALTER TABLE general_damage DROP repair_company_id, DROP police_recording_id, DROP has_items_other_insurance');
    }
}
