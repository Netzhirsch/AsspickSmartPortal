<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210209104322 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("INSERT INTO `damage_typ` (`id`, `name`) VALUES (NULL, 'Zusammenstoß'), (NULL, 'Vorfahrt verletzt'), (NULL, 'Auffahrunfall'), (NULL, 'Glasschaden'), (NULL, 'Wildschaden'), (NULL, 'Diebstahl'), (NULL, 'Brandschaden'), (NULL, 'Einbruchschaden'), (NULL, 'Sturmschaden'), (NULL, 'Hagelschaden'), (NULL, 'Vandalismus'), (NULL, 'Geparktes KFZ'), (NULL, 'Panne');");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
