<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250414182723 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE order_product ADD product_id INT NOT NULL, ADD command_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_product ADD CONSTRAINT FK_2530ADE64584665A FOREIGN KEY (product_id) REFERENCES product (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_product ADD CONSTRAINT FK_2530ADE633E1689A FOREIGN KEY (command_id) REFERENCES `order` (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2530ADE64584665A ON order_product (product_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2530ADE633E1689A ON order_product (command_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE order_product DROP FOREIGN KEY FK_2530ADE64584665A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_product DROP FOREIGN KEY FK_2530ADE633E1689A
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_2530ADE64584665A ON order_product
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_2530ADE633E1689A ON order_product
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_product DROP product_id, DROP command_id
        SQL);
    }
}
