<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210205070513 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE personal_injury (id INT AUTO_INCREMENT NOT NULL, person_firstname VARCHAR(255) NOT NULL, person_lastname VARCHAR(255) NOT NULL, injuries VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE liability ADD personal_injury_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE liability ADD CONSTRAINT FK_3B59ECCCA4089870 FOREIGN KEY (personal_injury_id) REFERENCES personal_injury (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3B59ECCCA4089870 ON liability (personal_injury_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liability DROP FOREIGN KEY FK_3B59ECCCA4089870');
        $this->addSql('DROP TABLE personal_injury');
        $this->addSql('DROP INDEX UNIQ_3B59ECCCA4089870 ON liability');
        $this->addSql('ALTER TABLE liability DROP personal_injury_id');
    }
}
