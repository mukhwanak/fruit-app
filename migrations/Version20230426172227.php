<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230426172227 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

   public function up(Schema $schema): void
    {
        // create fruit table
        $this->addSql('CREATE TABLE fruit (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, family VARCHAR(255) DEFAULT NULL, `order` VARCHAR(255) DEFAULT NULL, genus VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');

        // create nutrition table
        $this->addSql('CREATE TABLE nutrition (id INT AUTO_INCREMENT NOT NULL, fruit_id INT DEFAULT NULL, calories INT DEFAULT NULL, fat INT DEFAULT NULL, sugar INT DEFAULT NULL, carbohydrates INT DEFAULT NULL, protein INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE nutrition ADD CONSTRAINT FK_nutution_fruit_id FOREIGN KEY (fruit_id) REFERENCES fruit (id)');

        // create favorites table
        $this->addSql('CREATE TABLE favorite (id INT AUTO_INCREMENT NOT NULL, fruit_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_favourite_fruit_id FOREIGN KEY (fruit_id) REFERENCES fruit (id)');
    }

    public function down(Schema $schema): void
    {
        // drop favorites table
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_favourite_fruit_id');
        $this->addSql('DROP TABLE favorite');

        // drop nutrition table
        $this->addSql('ALTER TABLE nutrition DROP FOREIGN KEY FK_nutution_fruit_id');
        $this->addSql('DROP TABLE nutrition');

        // drop fruit table
        $this->addSql('DROP TABLE fruit');
    }
}
