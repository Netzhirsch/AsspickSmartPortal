<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210212132146 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car ADD is_locked TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE general_damage ADD is_locked TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE liability ADD is_locked TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP is_locked');
        $this->addSql('ALTER TABLE general_damage DROP is_locked');
        $this->addSql('ALTER TABLE liability DROP is_locked');
    }
}
