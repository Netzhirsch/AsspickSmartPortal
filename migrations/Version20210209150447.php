<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210209150447 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car ADD witness_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DF28D7E1C FOREIGN KEY (witness_id) REFERENCES witness (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_773DE69DF28D7E1C ON car (witness_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DF28D7E1C');
        $this->addSql('DROP INDEX UNIQ_773DE69DF28D7E1C ON car');
        $this->addSql('ALTER TABLE car DROP witness_id');
    }
}
