<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250414182835 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE order_product DROP FOREIGN KEY FK_2530ADE633E1689A
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_2530ADE633E1689A ON order_product
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_product CHANGE command_id order_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_product ADD CONSTRAINT FK_2530ADE68D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2530ADE68D9F6D38 ON order_product (order_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE order_product DROP FOREIGN KEY FK_2530ADE68D9F6D38
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_2530ADE68D9F6D38 ON order_product
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_product CHANGE order_id command_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_product ADD CONSTRAINT FK_2530ADE633E1689A FOREIGN KEY (command_id) REFERENCES `order` (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2530ADE633E1689A ON order_product (command_id)
        SQL);
    }
}
