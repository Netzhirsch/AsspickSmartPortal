<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210215094049 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car ADD witness_two_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DDA370037 FOREIGN KEY (witness_two_id) REFERENCES witness (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_773DE69DDA370037 ON car (witness_two_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DDA370037');
        $this->addSql('DROP INDEX UNIQ_773DE69DDA370037 ON car');
        $this->addSql('ALTER TABLE car DROP witness_two_id');
    }
}
