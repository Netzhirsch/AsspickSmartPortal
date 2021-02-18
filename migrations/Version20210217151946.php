<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210217151946 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE news (id INT AUTO_INCREMENT NOT NULL, titel VARCHAR(255) NOT NULL, intro_text LONGTEXT DEFAULT NULL, subtitel LONGTEXT DEFAULT NULL, text LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE file ADD news_id INT DEFAULT NULL, DROP extension');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610B5A459A0 FOREIGN KEY (news_id) REFERENCES news (id)');
        $this->addSql('CREATE INDEX IDX_8C9F3610B5A459A0 ON file (news_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610B5A459A0');
        $this->addSql('DROP TABLE news');
        $this->addSql('DROP INDEX IDX_8C9F3610B5A459A0 ON file');
        $this->addSql('ALTER TABLE file ADD extension VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP news_id');
    }
}
