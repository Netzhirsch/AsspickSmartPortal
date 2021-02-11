<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210210102033 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("INSERT INTO `general_damage_typ` (`id`, `name`) VALUES (NULL, 'Gebäude'), (NULL, 'Transport'), (NULL, 'Glas'), (NULL, 'Elementar'), (NULL, 'Inhalt'), (NULL, 'Ertragsausfall'), (NULL, 'Fahrraddiebstahl'), (NULL, 'Reisegepäck'), (NULL, 'Feuer/Blitz'), (NULL, 'Leitungswasser'), (NULL, 'Sturm/Hagel'), (NULL, 'ED/Vandalismus');");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
