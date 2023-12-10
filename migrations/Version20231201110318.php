<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231201110318 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart (id INT AUTO_INCREMENT NOT NULL, id_account_id INT NOT NULL, id_product_id INT NOT NULL, quantity INT NOT NULL, UNIQUE INDEX UNIQ_BA388B73EE1DF6D (id_account_id), UNIQUE INDEX UNIQ_BA388B7E00EE68D (id_product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detail_orders (id INT AUTO_INCREMENT NOT NULL, id_product_id INT NOT NULL, id_orders_id INT NOT NULL, quantity INT NOT NULL, UNIQUE INDEX UNIQ_F7E5E475E00EE68D (id_product_id), UNIQUE INDEX UNIQ_F7E5E4754FCB26F1 (id_orders_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, id_account_id INT NOT NULL, UNIQUE INDEX UNIQ_E52FFDEE3EE1DF6D (id_account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B73EE1DF6D FOREIGN KEY (id_account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7E00EE68D FOREIGN KEY (id_product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE detail_orders ADD CONSTRAINT FK_F7E5E475E00EE68D FOREIGN KEY (id_product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE detail_orders ADD CONSTRAINT FK_F7E5E4754FCB26F1 FOREIGN KEY (id_orders_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE3EE1DF6D FOREIGN KEY (id_account_id) REFERENCES account (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B73EE1DF6D');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7E00EE68D');
        $this->addSql('ALTER TABLE detail_orders DROP FOREIGN KEY FK_F7E5E475E00EE68D');
        $this->addSql('ALTER TABLE detail_orders DROP FOREIGN KEY FK_F7E5E4754FCB26F1');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE3EE1DF6D');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE detail_orders');
        $this->addSql('DROP TABLE orders');
    }
}
