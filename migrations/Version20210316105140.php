<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210316105140 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DFC2A5C84');
        $this->addSql('ALTER TABLE general_damage DROP FOREIGN KEY FK_80E0A928FC2A5C84');
        $this->addSql('ALTER TABLE liability DROP FOREIGN KEY FK_3B59ECCCFC2A5C84');
        $this->addSql('CREATE TABLE insurer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, insurance_number VARCHAR(255) DEFAULT NULL, danger_number VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE insured');
        $this->addSql('DROP INDEX UNIQ_773DE69DFC2A5C84 ON car');
        $this->addSql('ALTER TABLE car CHANGE insured_id insurer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D895854C7 FOREIGN KEY (insurer_id) REFERENCES insurer (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_773DE69D895854C7 ON car (insurer_id)');
        $this->addSql('DROP INDEX UNIQ_80E0A928FC2A5C84 ON general_damage');
        $this->addSql('ALTER TABLE general_damage CHANGE insured_id insurer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE general_damage ADD CONSTRAINT FK_80E0A928895854C7 FOREIGN KEY (insurer_id) REFERENCES insurer (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_80E0A928895854C7 ON general_damage (insurer_id)');
        $this->addSql('ALTER TABLE items_other_insurance CHANGE insured insurer VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_3B59ECCCFC2A5C84 ON liability');
        $this->addSql('ALTER TABLE liability CHANGE insured_id insurer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE liability ADD CONSTRAINT FK_3B59ECCC895854C7 FOREIGN KEY (insurer_id) REFERENCES insurer (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3B59ECCC895854C7 ON liability (insurer_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D895854C7');
        $this->addSql('ALTER TABLE general_damage DROP FOREIGN KEY FK_80E0A928895854C7');
        $this->addSql('ALTER TABLE liability DROP FOREIGN KEY FK_3B59ECCC895854C7');
        $this->addSql('CREATE TABLE insured (id INT AUTO_INCREMENT NOT NULL, insured VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, insurance_number VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, danger_number VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE insurer');
        $this->addSql('DROP INDEX UNIQ_773DE69D895854C7 ON car');
        $this->addSql('ALTER TABLE car CHANGE insurer_id insured_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DFC2A5C84 FOREIGN KEY (insured_id) REFERENCES insured (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_773DE69DFC2A5C84 ON car (insured_id)');
        $this->addSql('DROP INDEX UNIQ_80E0A928895854C7 ON general_damage');
        $this->addSql('ALTER TABLE general_damage CHANGE insurer_id insured_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE general_damage ADD CONSTRAINT FK_80E0A928FC2A5C84 FOREIGN KEY (insured_id) REFERENCES insured (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_80E0A928FC2A5C84 ON general_damage (insured_id)');
        $this->addSql('ALTER TABLE items_other_insurance CHANGE insurer insured VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX UNIQ_3B59ECCC895854C7 ON liability');
        $this->addSql('ALTER TABLE liability CHANGE insurer_id insured_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE liability ADD CONSTRAINT FK_3B59ECCCFC2A5C84 FOREIGN KEY (insured_id) REFERENCES insured (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3B59ECCCFC2A5C84 ON liability (insured_id)');
    }
}
