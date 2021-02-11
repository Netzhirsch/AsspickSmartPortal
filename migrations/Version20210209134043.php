<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210209134043 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE car_whose_car (car_id INT NOT NULL, whose_car_id INT NOT NULL, INDEX IDX_CCAF68B5C3C6F69F (car_id), INDEX IDX_CCAF68B517401939 (whose_car_id), PRIMARY KEY(car_id, whose_car_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE whose_car (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car_whose_car ADD CONSTRAINT FK_CCAF68B5C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE car_whose_car ADD CONSTRAINT FK_CCAF68B517401939 FOREIGN KEY (whose_car_id) REFERENCES whose_car (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car_whose_car DROP FOREIGN KEY FK_CCAF68B517401939');
        $this->addSql('DROP TABLE car_whose_car');
        $this->addSql('DROP TABLE whose_car');
    }
}
