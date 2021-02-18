<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210209141206 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car ADD police_recording_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D330EFAD7 FOREIGN KEY (police_recording_id) REFERENCES police_recording (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_773DE69D330EFAD7 ON car (police_recording_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D330EFAD7');
        $this->addSql('DROP INDEX UNIQ_773DE69D330EFAD7 ON car');
        $this->addSql('ALTER TABLE car DROP police_recording_id');
    }
}
