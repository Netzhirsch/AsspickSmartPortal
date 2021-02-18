<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210209093358 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accident_opponent (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, street_mailbox VARCHAR(255) DEFAULT NULL, post_code VARCHAR(255) DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car ADD accident_opponent_id INT DEFAULT NULL, ADD has_own_claims TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D69BD643C FOREIGN KEY (accident_opponent_id) REFERENCES accident_opponent (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_773DE69D69BD643C ON car (accident_opponent_id)');
        $this->addSql('ALTER TABLE driver CHANGE exhibition_location exhibition_location VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D69BD643C');
        $this->addSql('DROP TABLE accident_opponent');
        $this->addSql('DROP INDEX UNIQ_773DE69D69BD643C ON car');
        $this->addSql('ALTER TABLE car DROP accident_opponent_id, DROP has_own_claims');
        $this->addSql('ALTER TABLE driver CHANGE exhibition_location exhibition_location VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
