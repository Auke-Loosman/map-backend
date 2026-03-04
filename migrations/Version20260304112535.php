<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260304112535 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__categories AS SELECT id, name, user_id FROM categories');
        $this->addSql('DROP TABLE categories');
        $this->addSql('CREATE TABLE categories (id BLOB NOT NULL, name VARCHAR(255) NOT NULL, user_id BLOB NOT NULL, PRIMARY KEY (id))');
        $this->addSql('INSERT INTO categories (id, name, user_id) SELECT id, name, user_id FROM __temp__categories');
        $this->addSql('DROP TABLE __temp__categories');
        $this->addSql('CREATE TEMPORARY TABLE __temp__users AS SELECT id, email, password, role FROM users');
        $this->addSql('DROP TABLE users');
        $this->addSql('CREATE TABLE users (id BLOB NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY (id))');
        $this->addSql('INSERT INTO users (id, email, password, role) SELECT id, email, password, role FROM __temp__users');
        $this->addSql('DROP TABLE __temp__users');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__categories AS SELECT id, name, user_id FROM categories');
        $this->addSql('DROP TABLE categories');
        $this->addSql('CREATE TABLE categories (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, user_id INTEGER NOT NULL)');
        $this->addSql('INSERT INTO categories (id, name, user_id) SELECT id, name, user_id FROM __temp__categories');
        $this->addSql('DROP TABLE __temp__categories');
        $this->addSql('CREATE TEMPORARY TABLE __temp__users AS SELECT id, email, password, role FROM users');
        $this->addSql('DROP TABLE users');
        $this->addSql('CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO users (id, email, password, role) SELECT id, email, password, role FROM __temp__users');
        $this->addSql('DROP TABLE __temp__users');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
    }
}
