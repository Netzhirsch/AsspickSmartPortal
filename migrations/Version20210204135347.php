<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210204135347 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liability ADD claimant_id INT NOT NULL');
        $this->addSql('ALTER TABLE liability ADD CONSTRAINT FK_3B59ECCC9F409843 FOREIGN KEY (claimant_id) REFERENCES claimant (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3B59ECCC9F409843 ON liability (claimant_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liability DROP FOREIGN KEY FK_3B59ECCC9F409843');
        $this->addSql('DROP INDEX UNIQ_3B59ECCC9F409843 ON liability');
        $this->addSql('ALTER TABLE liability DROP claimant_id');
    }
}
