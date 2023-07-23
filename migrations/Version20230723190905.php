<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230723190905 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abstract_invoice (id INT AUTO_INCREMENT NOT NULL, related_order_id INT DEFAULT NULL, vendor_order_id INT DEFAULT NULL, sub_total NUMERIC(10, 0) NOT NULL, fed_tax_amount NUMERIC(10, 0) NOT NULL, provincial_tax_amount NUMERIC(10, 0) NOT NULL, grand_total NUMERIC(10, 0) NOT NULL, invoice_number VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, dtype VARCHAR(255) NOT NULL, INDEX IDX_32D271D42B1C2395 (related_order_id), INDEX IDX_32D271D4508C66C9 (vendor_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE abstract_invoice ADD CONSTRAINT FK_32D271D42B1C2395 FOREIGN KEY (related_order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE abstract_invoice ADD CONSTRAINT FK_32D271D4508C66C9 FOREIGN KEY (vendor_order_id) REFERENCES vendor_order (id)');
        $this->addSql('ALTER TABLE `order` CHANGE total_amount sub_total NUMERIC(10, 0) NOT NULL');
        $this->addSql('ALTER TABLE vendor_order CHANGE total_amount sub_total NUMERIC(10, 0) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abstract_invoice DROP FOREIGN KEY FK_32D271D42B1C2395');
        $this->addSql('ALTER TABLE abstract_invoice DROP FOREIGN KEY FK_32D271D4508C66C9');
        $this->addSql('DROP TABLE abstract_invoice');
        $this->addSql('ALTER TABLE `order` CHANGE sub_total total_amount NUMERIC(10, 0) NOT NULL');
        $this->addSql('ALTER TABLE vendor_order CHANGE sub_total total_amount NUMERIC(10, 0) NOT NULL');
    }
}
