<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210211150854 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file DROP size');
        $this->addSql('ALTER TABLE liability CHANGE insured_id insured_id INT DEFAULT NULL, CHANGE damage_event_id damage_event_id INT DEFAULT NULL, CHANGE payment_id payment_id INT DEFAULT NULL, CHANGE is_repair_possible is_repair_possible TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file ADD size VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE liability CHANGE insured_id insured_id INT NOT NULL, CHANGE damage_event_id damage_event_id INT NOT NULL, CHANGE payment_id payment_id INT NOT NULL, CHANGE is_repair_possible is_repair_possible TINYINT(1) NOT NULL');
    }
}
