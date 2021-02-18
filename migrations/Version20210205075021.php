<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210205075021 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, bank VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, iban VARCHAR(255) NOT NULL, bic VARCHAR(255) NOT NULL, account_holder VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE signature (id INT AUTO_INCREMENT NOT NULL, location VARCHAR(255) NOT NULL, date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE liability ADD payment_id INT NOT NULL, ADD signature_id INT NOT NULL');
        $this->addSql('ALTER TABLE liability ADD CONSTRAINT FK_3B59ECCC4C3A3BB FOREIGN KEY (payment_id) REFERENCES payment (id)');
        $this->addSql('ALTER TABLE liability ADD CONSTRAINT FK_3B59ECCCED61183A FOREIGN KEY (signature_id) REFERENCES signature (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3B59ECCC4C3A3BB ON liability (payment_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3B59ECCCED61183A ON liability (signature_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liability DROP FOREIGN KEY FK_3B59ECCC4C3A3BB');
        $this->addSql('ALTER TABLE liability DROP FOREIGN KEY FK_3B59ECCCED61183A');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE signature');
        $this->addSql('DROP INDEX UNIQ_3B59ECCC4C3A3BB ON liability');
        $this->addSql('DROP INDEX UNIQ_3B59ECCCED61183A ON liability');
        $this->addSql('ALTER TABLE liability DROP payment_id, DROP signature_id');
    }
}
