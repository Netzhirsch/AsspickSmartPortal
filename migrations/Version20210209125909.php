<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210209125909 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car CHANGE typ_of_insurance_id typ_of_insurance_id INT DEFAULT NULL, CHANGE typ_of_trip_id typ_of_trip_id INT DEFAULT NULL, CHANGE insured_id insured_id INT DEFAULT NULL, CHANGE policyholder_id policyholder_id INT DEFAULT NULL, CHANGE damage_event_id damage_event_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car CHANGE typ_of_insurance_id typ_of_insurance_id INT NOT NULL, CHANGE typ_of_trip_id typ_of_trip_id INT NOT NULL, CHANGE insured_id insured_id INT NOT NULL, CHANGE policyholder_id policyholder_id INT NOT NULL, CHANGE damage_event_id damage_event_id INT NOT NULL');
    }
}
