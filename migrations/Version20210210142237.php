<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210210142237 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, liability_id INT DEFAULT NULL, car_id INT DEFAULT NULL, general_damage_id INT DEFAULT NULL, upload_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, size VARCHAR(255) DEFAULT NULL, extension VARCHAR(255) NOT NULL, INDEX IDX_8C9F36101E88FF9F (liability_id), INDEX IDX_8C9F3610C3C6F69F (car_id), INDEX IDX_8C9F36108FD03730 (general_damage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F36101E88FF9F FOREIGN KEY (liability_id) REFERENCES liability (id)');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F36108FD03730 FOREIGN KEY (general_damage_id) REFERENCES general_damage (id)');
        $this->addSql('ALTER TABLE general_damage ADD trace_of_break_in_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE general_damage ADD CONSTRAINT FK_80E0A9285BDC478E FOREIGN KEY (trace_of_break_in_id) REFERENCES trace_of_break_in (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_80E0A9285BDC478E ON general_damage (trace_of_break_in_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE file');
        $this->addSql('ALTER TABLE general_damage DROP FOREIGN KEY FK_80E0A9285BDC478E');
        $this->addSql('DROP INDEX UNIQ_80E0A9285BDC478E ON general_damage');
        $this->addSql('ALTER TABLE general_damage DROP trace_of_break_in_id');
    }
}
