<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210210090506 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE general_damage (id INT AUTO_INCREMENT NOT NULL, insured_id INT DEFAULT NULL, policyholder_id INT DEFAULT NULL, payment_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_80E0A928FC2A5C84 (insured_id), UNIQUE INDEX UNIQ_80E0A928D1F9FFBD (policyholder_id), UNIQUE INDEX UNIQ_80E0A9284C3A3BB (payment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE general_damage_general_damage_typ (general_damage_id INT NOT NULL, general_damage_typ_id INT NOT NULL, INDEX IDX_5E9A39048FD03730 (general_damage_id), INDEX IDX_5E9A3904D97371CE (general_damage_typ_id), PRIMARY KEY(general_damage_id, general_damage_typ_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE general_damage_typ (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE general_damage ADD CONSTRAINT FK_80E0A928FC2A5C84 FOREIGN KEY (insured_id) REFERENCES insured (id)');
        $this->addSql('ALTER TABLE general_damage ADD CONSTRAINT FK_80E0A928D1F9FFBD FOREIGN KEY (policyholder_id) REFERENCES policyholder (id)');
        $this->addSql('ALTER TABLE general_damage ADD CONSTRAINT FK_80E0A9284C3A3BB FOREIGN KEY (payment_id) REFERENCES payment (id)');
        $this->addSql('ALTER TABLE general_damage_general_damage_typ ADD CONSTRAINT FK_5E9A39048FD03730 FOREIGN KEY (general_damage_id) REFERENCES general_damage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE general_damage_general_damage_typ ADD CONSTRAINT FK_5E9A3904D97371CE FOREIGN KEY (general_damage_typ_id) REFERENCES general_damage_typ (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE car DROP has_input_tax_deduction');
        $this->addSql('ALTER TABLE payment ADD has_input_tax_deduction TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE general_damage_general_damage_typ DROP FOREIGN KEY FK_5E9A39048FD03730');
        $this->addSql('ALTER TABLE general_damage_general_damage_typ DROP FOREIGN KEY FK_5E9A3904D97371CE');
        $this->addSql('DROP TABLE general_damage');
        $this->addSql('DROP TABLE general_damage_general_damage_typ');
        $this->addSql('DROP TABLE general_damage_typ');
        $this->addSql('ALTER TABLE car ADD has_input_tax_deduction TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE payment DROP has_input_tax_deduction');
    }
}
