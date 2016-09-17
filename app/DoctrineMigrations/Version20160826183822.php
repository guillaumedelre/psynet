<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160826183822 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE route (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category ADD route_id INT NOT NULL, DROP route');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C134ECB4E6 FOREIGN KEY (route_id) REFERENCES route (id) ON DELETE RESTRICT');
        $this->addSql('CREATE INDEX IDX_64C19C134ECB4E6 ON category (route_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C134ECB4E6');
        $this->addSql('DROP TABLE route');
        $this->addSql('DROP INDEX IDX_64C19C134ECB4E6 ON category');
        $this->addSql('ALTER TABLE category ADD route VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP route_id');
    }
}
