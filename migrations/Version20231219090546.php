<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231219090546 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cart_product (cart_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_2890CCAA1AD5CDBF (cart_id), INDEX IDX_2890CCAA4584665A (product_id), PRIMARY KEY(cart_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detail_orders_product (detail_orders_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_8C0FE5CDE094F63 (detail_orders_id), INDEX IDX_8C0FE5C4584665A (product_id), PRIMARY KEY(detail_orders_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cart_product ADD CONSTRAINT FK_2890CCAA1AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cart_product ADD CONSTRAINT FK_2890CCAA4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE detail_orders_product ADD CONSTRAINT FK_8C0FE5CDE094F63 FOREIGN KEY (detail_orders_id) REFERENCES detail_orders (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE detail_orders_product ADD CONSTRAINT FK_8C0FE5C4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE compose DROP FOREIGN KEY FK_AE4C14162D1731E9');
        $this->addSql('ALTER TABLE compose DROP FOREIGN KEY FK_AE4C1416E00EE68D');
        $this->addSql('DROP TABLE compose');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('ALTER TABLE account ADD role_id INT NOT NULL, DROP role, CHANGE name name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE account ADD CONSTRAINT FK_7D3656A4D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('CREATE INDEX IDX_7D3656A4D60322AC ON account (role_id)');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7E00EE68D');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B73EE1DF6D');
        $this->addSql('DROP INDEX UNIQ_BA388B73EE1DF6D ON cart');
        $this->addSql('DROP INDEX UNIQ_BA388B7E00EE68D ON cart');
        $this->addSql('ALTER TABLE cart ADD account_id INT NOT NULL, DROP id_account_id, DROP id_product_id');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B79B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BA388B79B6B5FBA ON cart (account_id)');
        $this->addSql('ALTER TABLE detail_orders DROP FOREIGN KEY FK_F7E5E4754FCB26F1');
        $this->addSql('ALTER TABLE detail_orders DROP FOREIGN KEY FK_F7E5E475E00EE68D');
        $this->addSql('DROP INDEX UNIQ_F7E5E475E00EE68D ON detail_orders');
        $this->addSql('DROP INDEX UNIQ_F7E5E4754FCB26F1 ON detail_orders');
        $this->addSql('ALTER TABLE detail_orders ADD orders_id INT NOT NULL, DROP id_product_id, DROP id_orders_id');
        $this->addSql('ALTER TABLE detail_orders ADD CONSTRAINT FK_F7E5E475CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES orders (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F7E5E475CFFE9AD6 ON detail_orders (orders_id)');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE3EE1DF6D');
        $this->addSql('DROP INDEX UNIQ_E52FFDEE3EE1DF6D ON orders');
        $this->addSql('ALTER TABLE orders CHANGE id_account_id account_id INT NOT NULL');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE9B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('CREATE INDEX IDX_E52FFDEE9B6B5FBA ON orders (account_id)');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADA545015');
        $this->addSql('DROP INDEX UNIQ_D34A04ADA545015 ON product');
        $this->addSql('ALTER TABLE product CHANGE id_category_id category_id INT NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD12469DE2 ON product (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account DROP FOREIGN KEY FK_7D3656A4D60322AC');
        $this->addSql('CREATE TABLE compose (id INT AUTO_INCREMENT NOT NULL, id_product_id INT NOT NULL, id_ingredient_id INT NOT NULL, UNIQUE INDEX UNIQ_AE4C1416E00EE68D (id_product_id), UNIQUE INDEX UNIQ_AE4C14162D1731E9 (id_ingredient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE compose ADD CONSTRAINT FK_AE4C14162D1731E9 FOREIGN KEY (id_ingredient_id) REFERENCES ingredient (id)');
        $this->addSql('ALTER TABLE compose ADD CONSTRAINT FK_AE4C1416E00EE68D FOREIGN KEY (id_product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE cart_product DROP FOREIGN KEY FK_2890CCAA1AD5CDBF');
        $this->addSql('ALTER TABLE cart_product DROP FOREIGN KEY FK_2890CCAA4584665A');
        $this->addSql('ALTER TABLE detail_orders_product DROP FOREIGN KEY FK_8C0FE5CDE094F63');
        $this->addSql('ALTER TABLE detail_orders_product DROP FOREIGN KEY FK_8C0FE5C4584665A');
        $this->addSql('DROP TABLE cart_product');
        $this->addSql('DROP TABLE detail_orders_product');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP INDEX IDX_7D3656A4D60322AC ON account');
        $this->addSql('ALTER TABLE account ADD role VARCHAR(50) NOT NULL, DROP role_id, CHANGE name name VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B79B6B5FBA');
        $this->addSql('DROP INDEX UNIQ_BA388B79B6B5FBA ON cart');
        $this->addSql('ALTER TABLE cart ADD id_product_id INT NOT NULL, CHANGE account_id id_account_id INT NOT NULL');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7E00EE68D FOREIGN KEY (id_product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B73EE1DF6D FOREIGN KEY (id_account_id) REFERENCES account (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BA388B73EE1DF6D ON cart (id_account_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BA388B7E00EE68D ON cart (id_product_id)');
        $this->addSql('ALTER TABLE detail_orders DROP FOREIGN KEY FK_F7E5E475CFFE9AD6');
        $this->addSql('DROP INDEX UNIQ_F7E5E475CFFE9AD6 ON detail_orders');
        $this->addSql('ALTER TABLE detail_orders ADD id_orders_id INT NOT NULL, CHANGE orders_id id_product_id INT NOT NULL');
        $this->addSql('ALTER TABLE detail_orders ADD CONSTRAINT FK_F7E5E4754FCB26F1 FOREIGN KEY (id_orders_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE detail_orders ADD CONSTRAINT FK_F7E5E475E00EE68D FOREIGN KEY (id_product_id) REFERENCES product (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F7E5E475E00EE68D ON detail_orders (id_product_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F7E5E4754FCB26F1 ON detail_orders (id_orders_id)');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE9B6B5FBA');
        $this->addSql('DROP INDEX IDX_E52FFDEE9B6B5FBA ON orders');
        $this->addSql('ALTER TABLE orders CHANGE account_id id_account_id INT NOT NULL');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE3EE1DF6D FOREIGN KEY (id_account_id) REFERENCES account (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E52FFDEE3EE1DF6D ON orders (id_account_id)');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('DROP INDEX IDX_D34A04AD12469DE2 ON product');
        $this->addSql('ALTER TABLE product CHANGE category_id id_category_id INT NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADA545015 FOREIGN KEY (id_category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX UNIQ_D34A04ADA545015 ON product (id_category_id)');
    }
}
