<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200412121726 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE melogram (id INT AUTO_INCREMENT NOT NULL, uid VARCHAR(255) NOT NULL, item INT NOT NULL, family INT NOT NULL, colony INT NOT NULL, population INT NOT NULL, specie INT NOT NULL, file LONGBLOB NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE selection_item (id INT AUTO_INCREMENT NOT NULL, selection_id INT DEFAULT NULL, melogram_id INT DEFAULT NULL, INDEX IDX_CB95FBE3E48EFE78 (selection_id), INDEX IDX_CB95FBE38870D6E0 (melogram_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE selection (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE selection_item ADD CONSTRAINT FK_CB95FBE3E48EFE78 FOREIGN KEY (selection_id) REFERENCES selection (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE selection_item ADD CONSTRAINT FK_CB95FBE38870D6E0 FOREIGN KEY (melogram_id) REFERENCES melogram (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE selection_item DROP FOREIGN KEY FK_CB95FBE38870D6E0');
        $this->addSql('ALTER TABLE selection_item DROP FOREIGN KEY FK_CB95FBE3E48EFE78');
        $this->addSql('DROP TABLE melogram');
        $this->addSql('DROP TABLE selection_item');
        $this->addSql('DROP TABLE selection');
        $this->addSql('DROP TABLE user');
    }
}
