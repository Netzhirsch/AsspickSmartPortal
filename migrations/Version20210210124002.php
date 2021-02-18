<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210210124002 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE general_damage ADD building_damage_id INT DEFAULT NULL, DROP is_repair_possible');
        $this->addSql('ALTER TABLE general_damage ADD CONSTRAINT FK_80E0A928908621CA FOREIGN KEY (building_damage_id) REFERENCES building_damage (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_80E0A928908621CA ON general_damage (building_damage_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE general_damage DROP FOREIGN KEY FK_80E0A928908621CA');
        $this->addSql('DROP INDEX UNIQ_80E0A928908621CA ON general_damage');
        $this->addSql('ALTER TABLE general_damage ADD is_repair_possible TINYINT(1) DEFAULT NULL, DROP building_damage_id');
    }
}
