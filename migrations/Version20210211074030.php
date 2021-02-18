<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210211074030 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE signature');
        $this->addSql('ALTER TABLE liability ADD CONSTRAINT FK_3B59ECCCD1F9FFBD FOREIGN KEY (policyholder_id) REFERENCES policyholder (id)');
        $this->addSql('ALTER TABLE liability ADD CONSTRAINT FK_3B59ECCC37422B5 FOREIGN KEY (damage_event_id) REFERENCES damage_event (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3B59ECCCD1F9FFBD ON liability (policyholder_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE signature (id INT AUTO_INCREMENT NOT NULL, location VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE liability DROP FOREIGN KEY FK_3B59ECCCD1F9FFBD');
        $this->addSql('ALTER TABLE liability DROP FOREIGN KEY FK_3B59ECCC37422B5');
        $this->addSql('DROP INDEX UNIQ_3B59ECCCD1F9FFBD ON liability');
    }
}
