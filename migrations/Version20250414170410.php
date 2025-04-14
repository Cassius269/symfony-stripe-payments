<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250414170410 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE `order` ADD client_id INT NOT NULL, ADD status_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `order` ADD CONSTRAINT FK_F529939819EB6921 FOREIGN KEY (client_id) REFERENCES client (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `order` ADD CONSTRAINT FK_F52993986BF700BD FOREIGN KEY (status_id) REFERENCES status (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_F529939819EB6921 ON `order` (client_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_F52993986BF700BD ON `order` (status_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE `order` DROP FOREIGN KEY FK_F529939819EB6921
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `order` DROP FOREIGN KEY FK_F52993986BF700BD
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_F529939819EB6921 ON `order`
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_F52993986BF700BD ON `order`
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `order` DROP client_id, DROP status_id
        SQL);
    }
}
