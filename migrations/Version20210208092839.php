<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210208092839 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("INSERT INTO `typ_of_insurance` (`id`, `name`) VALUES (NULL, 'Haftpflicht'), (NULL, 'Kasko');");
        $this->addSql("INSERT INTO `typ_of_trip` (`id`, `name`) VALUES (NULL, 'Dienstfahrt'), (NULL, 'Privatfahrt');");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
