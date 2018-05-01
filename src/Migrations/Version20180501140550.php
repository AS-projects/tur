<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180501140550 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE category (id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, is_nsfw BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE element (id INTEGER NOT NULL, ranking_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, votes INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_41405E3920F64684 ON element (ranking_id)');
        $this->addSql('CREATE TABLE ranking (id INTEGER NOT NULL, category_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, votes INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_80B839D012469DE2 ON ranking (category_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE element');
        $this->addSql('DROP TABLE ranking');
    }
}
