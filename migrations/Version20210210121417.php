<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210210121417 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE general_damage ADD damage_cause_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE general_damage ADD CONSTRAINT FK_80E0A9281461E820 FOREIGN KEY (damage_cause_id) REFERENCES damage_cause (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_80E0A9281461E820 ON general_damage (damage_cause_id)');
        $this->addSql('ALTER TABLE relationship_to_building ADD general_damage_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE relationship_to_building ADD CONSTRAINT FK_E7F6B1288FD03730 FOREIGN KEY (general_damage_id) REFERENCES general_damage (id)');
        $this->addSql('CREATE INDEX IDX_E7F6B1288FD03730 ON relationship_to_building (general_damage_id)');
        $this->addSql('ALTER TABLE repair_company ADD email VARCHAR(255) DEFAULT NULL, ADD phone VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE general_damage DROP FOREIGN KEY FK_80E0A9281461E820');
        $this->addSql('DROP INDEX UNIQ_80E0A9281461E820 ON general_damage');
        $this->addSql('ALTER TABLE general_damage DROP damage_cause_id');
        $this->addSql('ALTER TABLE relationship_to_building DROP FOREIGN KEY FK_E7F6B1288FD03730');
        $this->addSql('DROP INDEX IDX_E7F6B1288FD03730 ON relationship_to_building');
        $this->addSql('ALTER TABLE relationship_to_building DROP general_damage_id');
        $this->addSql('ALTER TABLE repair_company DROP email, DROP phone');
    }
}
