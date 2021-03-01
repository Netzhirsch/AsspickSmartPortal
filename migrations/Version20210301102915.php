<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210301102915 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activation_code ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE activation_code ADD CONSTRAINT FK_FA574C9AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FA574C9AA76ED395 ON activation_code (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activation_code DROP FOREIGN KEY FK_FA574C9AA76ED395');
        $this->addSql('DROP INDEX UNIQ_FA574C9AA76ED395 ON activation_code');
        $this->addSql('ALTER TABLE activation_code DROP user_id');
    }
}
