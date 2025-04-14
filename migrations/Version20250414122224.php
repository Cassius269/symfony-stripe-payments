<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250414122224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE `admin` (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE client (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `admin` ADD CONSTRAINT FK_880E0D76BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE client ADD CONSTRAINT FK_C7440455BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD dtype VARCHAR(255) NOT NULL, DROP firstname, DROP lastname, DROP created_at, DROP updated_at
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE `admin` DROP FOREIGN KEY FK_880E0D76BF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE client DROP FOREIGN KEY FK_C7440455BF396750
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE `admin`
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE client
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD firstname VARCHAR(50) NOT NULL, ADD lastname VARCHAR(50) NOT NULL, ADD created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', ADD updated_at DATETIME DEFAULT NULL, DROP dtype
        SQL);
    }
}
