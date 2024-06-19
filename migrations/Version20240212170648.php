<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240212170648 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE produits ADD category_id INT NOT NULL');
        $this->addSql('CREATE TABLE category_shop (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE produits ADD slug VARCHAR(255) NOT NULL, ADD online TINYINT(1) NOT NULL, ADD subtitle VARCHAR(255) NOT NULL, ADD datetime DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE category_shop');
        $this->addSql('ALTER TABLE produits DROP category_id');
        $this->addSql('ALTER TABLE produits DROP slug, DROP online, DROP subtitle, DROP datetime, DROP updated_at');
    }
    
}
