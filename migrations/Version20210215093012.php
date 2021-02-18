<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210215093012 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE damage_cause DROP email');
        $this->addSql('ALTER TABLE liability ADD witness_two_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE liability ADD CONSTRAINT FK_3B59ECCCDA370037 FOREIGN KEY (witness_two_id) REFERENCES witness (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3B59ECCCDA370037 ON liability (witness_two_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE damage_cause ADD email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE liability DROP FOREIGN KEY FK_3B59ECCCDA370037');
        $this->addSql('DROP INDEX UNIQ_3B59ECCCDA370037 ON liability');
        $this->addSql('ALTER TABLE liability DROP witness_two_id');
    }
}
