<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240415121708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` ADD user_id INT NOT NULL, ADD created_at DATETIME NOT NULL, ADD transporter_name VARCHAR(255) NOT NULL, ADD transporter_price DOUBLE PRECISION NOT NULL, ADD delivery LONGTEXT NOT NULL, ADD is_paid TINYINT(1) NOT NULL, ADD method VARCHAR(255) NOT NULL, ADD reference VARCHAR(255) NOT NULL, ADD stripe_session_id VARCHAR(255) DEFAULT NULL, ADD paypal_order_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F5299398A76ED395 ON `order` (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('DROP INDEX IDX_F5299398A76ED395 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP user_id, DROP created_at, DROP transporter_name, DROP transporter_price, DROP delivery, DROP is_paid, DROP method, DROP reference, DROP stripe_session_id, DROP paypal_order_id');
    }
    
}
