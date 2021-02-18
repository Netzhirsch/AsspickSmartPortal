<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210209143825 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE police_recording_who_is_warned_with_charge (police_recording_id INT NOT NULL, who_is_warned_with_charge_id INT NOT NULL, INDEX IDX_B6050EA7330EFAD7 (police_recording_id), INDEX IDX_B6050EA7E24DDD39 (who_is_warned_with_charge_id), PRIMARY KEY(police_recording_id, who_is_warned_with_charge_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE who_is_warned_with_charge (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE police_recording_who_is_warned_with_charge ADD CONSTRAINT FK_B6050EA7330EFAD7 FOREIGN KEY (police_recording_id) REFERENCES police_recording (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE police_recording_who_is_warned_with_charge ADD CONSTRAINT FK_B6050EA7E24DDD39 FOREIGN KEY (who_is_warned_with_charge_id) REFERENCES who_is_warned_with_charge (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE police_recording ADD is_warned_with_charge TINYINT(1) DEFAULT NULL, ADD has_drug_use TINYINT(1) DEFAULT NULL, ADD has_drug_test TINYINT(1) DEFAULT NULL, ADD drug_test_result NUMERIC(10, 1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE police_recording_who_is_warned_with_charge DROP FOREIGN KEY FK_B6050EA7E24DDD39');
        $this->addSql('DROP TABLE police_recording_who_is_warned_with_charge');
        $this->addSql('DROP TABLE who_is_warned_with_charge');
        $this->addSql('ALTER TABLE police_recording DROP is_warned_with_charge, DROP has_drug_use, DROP has_drug_test, DROP drug_test_result');
    }
}
