<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210204144213 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE type_of_ownership (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE damage_event ADD damage_amount DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE liability ADD type_of_ownership_id INT DEFAULT NULL, ADD is_repair_possible TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE liability ADD CONSTRAINT FK_3B59ECCC89FE0BF9 FOREIGN KEY (type_of_ownership_id) REFERENCES type_of_ownership (id)');
        $this->addSql('CREATE INDEX IDX_3B59ECCC89FE0BF9 ON liability (type_of_ownership_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liability DROP FOREIGN KEY FK_3B59ECCC89FE0BF9');
        $this->addSql('DROP TABLE type_of_ownership');
        $this->addSql('ALTER TABLE damage_event DROP damage_amount');
        $this->addSql('DROP INDEX IDX_3B59ECCC89FE0BF9 ON liability');
        $this->addSql('ALTER TABLE liability DROP type_of_ownership_id, DROP is_repair_possible');
    }
}
