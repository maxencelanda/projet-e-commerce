<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240528124322 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE type_order (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, couleur VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE orders ADD type_order_id INT NOT NULL, ADD date_order DATETIME NOT NULL');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE40604AC4 FOREIGN KEY (type_order_id) REFERENCES type_order (id)');
        $this->addSql('CREATE INDEX IDX_E52FFDEE40604AC4 ON orders (type_order_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE40604AC4');
        $this->addSql('DROP TABLE type_order');
        $this->addSql('DROP INDEX IDX_E52FFDEE40604AC4 ON orders');
        $this->addSql('ALTER TABLE orders DROP type_order_id, DROP date_order');
    }
}
