<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210204144324 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("INSERT INTO `type_of_ownership` (`id`, `name`) VALUES (NULL, 'gemietet'), (NULL, 'in Verwahrung'), (NULL, 'zu befördern'), (NULL, 'zu bearbeiten'), (NULL, 'zu reparieren'), (NULL, 'geliehen'); ");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
