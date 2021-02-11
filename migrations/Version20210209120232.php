<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210209120232 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE damage_event_damage_typ (damage_event_id INT NOT NULL, damage_typ_id INT NOT NULL, INDEX IDX_870E8DF837422B5 (damage_event_id), INDEX IDX_870E8DF83476C867 (damage_typ_id), PRIMARY KEY(damage_event_id, damage_typ_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE damage_event_damage_typ ADD CONSTRAINT FK_870E8DF837422B5 FOREIGN KEY (damage_event_id) REFERENCES damage_event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE damage_event_damage_typ ADD CONSTRAINT FK_870E8DF83476C867 FOREIGN KEY (damage_typ_id) REFERENCES damage_typ (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE damage_event_damage_typ');
    }
}
