<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210209135500 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE police_recording_criminal_proceedings_against_typ (police_recording_id INT NOT NULL, criminal_proceedings_against_typ_id INT NOT NULL, INDEX IDX_FCE8BE54330EFAD7 (police_recording_id), INDEX IDX_FCE8BE548CB61D50 (criminal_proceedings_against_typ_id), PRIMARY KEY(police_recording_id, criminal_proceedings_against_typ_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE police_recording_criminal_proceedings_against_typ ADD CONSTRAINT FK_FCE8BE54330EFAD7 FOREIGN KEY (police_recording_id) REFERENCES police_recording (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE police_recording_criminal_proceedings_against_typ ADD CONSTRAINT FK_FCE8BE548CB61D50 FOREIGN KEY (criminal_proceedings_against_typ_id) REFERENCES criminal_proceedings_against_typ (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE liability DROP FOREIGN KEY FK_3B59ECCCB6E5A16');
        $this->addSql('DROP INDEX IDX_3B59ECCCB6E5A16 ON liability');
        $this->addSql('ALTER TABLE liability DROP criminal_proceedings_against_id, DROP has_criminal_proceedings');
        $this->addSql('ALTER TABLE police_recording ADD has_criminal_proceedings TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE police_recording_criminal_proceedings_against_typ');
        $this->addSql('ALTER TABLE liability ADD criminal_proceedings_against_id INT DEFAULT NULL, ADD has_criminal_proceedings TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE liability ADD CONSTRAINT FK_3B59ECCCB6E5A16 FOREIGN KEY (criminal_proceedings_against_id) REFERENCES criminal_proceedings_against_typ (id)');
        $this->addSql('CREATE INDEX IDX_3B59ECCCB6E5A16 ON liability (criminal_proceedings_against_id)');
        $this->addSql('ALTER TABLE police_recording DROP has_criminal_proceedings');
    }
}
