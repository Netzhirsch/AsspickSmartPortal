<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210210130908 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE items_other_insurance (id INT AUTO_INCREMENT NOT NULL, has_other_insurance TINYINT(1) DEFAULT NULL, insured VARCHAR(255) DEFAULT NULL, insurance_number VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE general_damage ADD items_other_insurance_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE general_damage ADD CONSTRAINT FK_80E0A92823D75197 FOREIGN KEY (items_other_insurance_id) REFERENCES items_other_insurance (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_80E0A92823D75197 ON general_damage (items_other_insurance_id)');
        $this->addSql('ALTER TABLE relationship_to_building DROP FOREIGN KEY FK_E7F6B1288FD03730');
        $this->addSql('DROP INDEX IDX_E7F6B1288FD03730 ON relationship_to_building');
        $this->addSql('ALTER TABLE relationship_to_building DROP general_damage_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE general_damage DROP FOREIGN KEY FK_80E0A92823D75197');
        $this->addSql('DROP TABLE items_other_insurance');
        $this->addSql('DROP INDEX UNIQ_80E0A92823D75197 ON general_damage');
        $this->addSql('ALTER TABLE general_damage DROP items_other_insurance_id');
        $this->addSql('ALTER TABLE relationship_to_building ADD general_damage_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE relationship_to_building ADD CONSTRAINT FK_E7F6B1288FD03730 FOREIGN KEY (general_damage_id) REFERENCES general_damage (id)');
        $this->addSql('CREATE INDEX IDX_E7F6B1288FD03730 ON relationship_to_building (general_damage_id)');
    }
}
