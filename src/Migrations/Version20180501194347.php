<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180501194347 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_41405E3920F64684');
        $this->addSql('CREATE TEMPORARY TABLE __temp__element AS SELECT id, ranking_id, name, description, votes FROM element');
        $this->addSql('DROP TABLE element');
        $this->addSql('CREATE TABLE element (id INTEGER NOT NULL, ranking_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB DEFAULT NULL COLLATE BINARY, votes INTEGER NOT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_41405E3920F64684 FOREIGN KEY (ranking_id) REFERENCES ranking (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO element (id, ranking_id, name, description, votes) SELECT id, ranking_id, name, description, votes FROM __temp__element');
        $this->addSql('DROP TABLE __temp__element');
        $this->addSql('CREATE INDEX IDX_41405E3920F64684 ON element (ranking_id)');
        $this->addSql('DROP INDEX IDX_80B839D012469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__ranking AS SELECT id, category_id, name, description, image, votes FROM ranking');
        $this->addSql('DROP TABLE ranking');
        $this->addSql('CREATE TABLE ranking (id INTEGER NOT NULL, category_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB DEFAULT NULL COLLATE BINARY, image VARCHAR(255) DEFAULT NULL COLLATE BINARY, votes INTEGER NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_80B839D012469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO ranking (id, category_id, name, description, image, votes) SELECT id, category_id, name, description, image, votes FROM __temp__ranking');
        $this->addSql('DROP TABLE __temp__ranking');
        $this->addSql('CREATE INDEX IDX_80B839D012469DE2 ON ranking (category_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_41405E3920F64684');
        $this->addSql('CREATE TEMPORARY TABLE __temp__element AS SELECT id, ranking_id, name, description, votes FROM element');
        $this->addSql('DROP TABLE element');
        $this->addSql('CREATE TABLE element (id INTEGER NOT NULL, ranking_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, votes INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO element (id, ranking_id, name, description, votes) SELECT id, ranking_id, name, description, votes FROM __temp__element');
        $this->addSql('DROP TABLE __temp__element');
        $this->addSql('CREATE INDEX IDX_41405E3920F64684 ON element (ranking_id)');
        $this->addSql('DROP INDEX IDX_80B839D012469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__ranking AS SELECT id, category_id, name, description, image, votes FROM ranking');
        $this->addSql('DROP TABLE ranking');
        $this->addSql('CREATE TABLE ranking (id INTEGER NOT NULL, category_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, votes INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO ranking (id, category_id, name, description, image, votes) SELECT id, category_id, name, description, image, votes FROM __temp__ranking');
        $this->addSql('DROP TABLE __temp__ranking');
        $this->addSql('CREATE INDEX IDX_80B839D012469DE2 ON ranking (category_id)');
    }
}
