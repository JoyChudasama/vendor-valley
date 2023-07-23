<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230723152342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vendor_order_item (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, vendor_order_id INT DEFAULT NULL, quantity INT NOT NULL, INDEX IDX_C89FCB6E4584665A (product_id), INDEX IDX_C89FCB6E508C66C9 (vendor_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vendor_order_item ADD CONSTRAINT FK_C89FCB6E4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE vendor_order_item ADD CONSTRAINT FK_C89FCB6E508C66C9 FOREIGN KEY (vendor_order_id) REFERENCES vendor_order (id)');
        $this->addSql('ALTER TABLE vendor_order_product DROP FOREIGN KEY FK_AD93F571508C66C9');
        $this->addSql('ALTER TABLE vendor_order_product DROP FOREIGN KEY FK_AD93F5714584665A');
        $this->addSql('DROP TABLE vendor_order_product');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vendor_order_product (vendor_order_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_AD93F571508C66C9 (vendor_order_id), INDEX IDX_AD93F5714584665A (product_id), PRIMARY KEY(vendor_order_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE vendor_order_product ADD CONSTRAINT FK_AD93F571508C66C9 FOREIGN KEY (vendor_order_id) REFERENCES vendor_order (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vendor_order_product ADD CONSTRAINT FK_AD93F5714584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vendor_order_item DROP FOREIGN KEY FK_C89FCB6E4584665A');
        $this->addSql('ALTER TABLE vendor_order_item DROP FOREIGN KEY FK_C89FCB6E508C66C9');
        $this->addSql('DROP TABLE vendor_order_item');
    }
}
