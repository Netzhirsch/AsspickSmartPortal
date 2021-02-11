<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210210102841 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE general_damage ADD damage_event_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE general_damage ADD CONSTRAINT FK_80E0A92837422B5 FOREIGN KEY (damage_event_id) REFERENCES damage_event (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_80E0A92837422B5 ON general_damage (damage_event_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE general_damage DROP FOREIGN KEY FK_80E0A92837422B5');
        $this->addSql('DROP INDEX UNIQ_80E0A92837422B5 ON general_damage');
        $this->addSql('ALTER TABLE general_damage DROP damage_event_id, DROP created_at');
    }
}
