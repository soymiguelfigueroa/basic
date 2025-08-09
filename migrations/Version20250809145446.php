<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250809145446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE snippet ADD COLUMN slug VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__snippet AS SELECT id, parent_id, author_id, title, description, code FROM snippet');
        $this->addSql('DROP TABLE snippet');
        $this->addSql('CREATE TABLE snippet (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, parent_id INTEGER DEFAULT NULL, author_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, code CLOB NOT NULL, CONSTRAINT FK_961C8CD5727ACA70 FOREIGN KEY (parent_id) REFERENCES snippet (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_961C8CD5F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO snippet (id, parent_id, author_id, title, description, code) SELECT id, parent_id, author_id, title, description, code FROM __temp__snippet');
        $this->addSql('DROP TABLE __temp__snippet');
        $this->addSql('CREATE INDEX IDX_961C8CD5727ACA70 ON snippet (parent_id)');
        $this->addSql('CREATE INDEX IDX_961C8CD5F675F31B ON snippet (author_id)');
    }
}
