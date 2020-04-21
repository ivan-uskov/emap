<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200421094750 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE selection_group (id INT AUTO_INCREMENT NOT NULL, hash VARCHAR(255) NOT NULL, date VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE selection_group_item (id INT AUTO_INCREMENT NOT NULL, selection_group_id INT DEFAULT NULL, selection_id INT DEFAULT NULL, INDEX IDX_2E8EE97529F1AC0F (selection_group_id), INDEX IDX_2E8EE975E48EFE78 (selection_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE selection_group_item ADD CONSTRAINT FK_2E8EE97529F1AC0F FOREIGN KEY (selection_group_id) REFERENCES selection_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE selection_group_item ADD CONSTRAINT FK_2E8EE975E48EFE78 FOREIGN KEY (selection_id) REFERENCES selection (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE selection_group_item DROP FOREIGN KEY FK_2E8EE97529F1AC0F');
        $this->addSql('DROP TABLE selection_group');
        $this->addSql('DROP TABLE selection_group_item');
    }
}
