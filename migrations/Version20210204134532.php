<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210204134532 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE claimant_typ (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE claimant ADD typ_id INT NOT NULL');
        $this->addSql('ALTER TABLE claimant ADD CONSTRAINT FK_C95EAA6278CD074 FOREIGN KEY (typ_id) REFERENCES claimant_typ (id)');
        $this->addSql('CREATE INDEX IDX_C95EAA6278CD074 ON claimant (typ_id)');
        $this->addSql('ALTER TABLE liability DROP FOREIGN KEY FK_3B59ECCC8CB61D50');
        $this->addSql('DROP INDEX UNIQ_3B59ECCC8CB61D50 ON liability');
        $this->addSql('ALTER TABLE liability ADD criminal_proceedings_against_id INT NOT NULL, DROP criminal_proceedings_against_typ_id');
        $this->addSql('ALTER TABLE liability ADD CONSTRAINT FK_3B59ECCCB6E5A16 FOREIGN KEY (criminal_proceedings_against_id) REFERENCES criminal_proceedings_against_typ (id)');
        $this->addSql('CREATE INDEX IDX_3B59ECCCB6E5A16 ON liability (criminal_proceedings_against_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE claimant DROP FOREIGN KEY FK_C95EAA6278CD074');
        $this->addSql('DROP TABLE claimant_typ');
        $this->addSql('DROP INDEX IDX_C95EAA6278CD074 ON claimant');
        $this->addSql('ALTER TABLE claimant DROP typ_id');
        $this->addSql('ALTER TABLE liability DROP FOREIGN KEY FK_3B59ECCCB6E5A16');
        $this->addSql('DROP INDEX IDX_3B59ECCCB6E5A16 ON liability');
        $this->addSql('ALTER TABLE liability ADD criminal_proceedings_against_typ_id INT DEFAULT NULL, DROP criminal_proceedings_against_id');
        $this->addSql('ALTER TABLE liability ADD CONSTRAINT FK_3B59ECCC8CB61D50 FOREIGN KEY (criminal_proceedings_against_typ_id) REFERENCES criminal_proceedings_against_typ (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3B59ECCC8CB61D50 ON liability (criminal_proceedings_against_typ_id)');
    }
}
