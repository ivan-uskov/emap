<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200303202345 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE colony (id INT AUTO_INCREMENT NOT NULL, population_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_C41C77DCC955D1E1 (population_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE colony_item (id INT AUTO_INCREMENT NOT NULL, colony_id INT DEFAULT NULL, item_id INT DEFAULT NULL, INDEX IDX_4279172696ADBADE (colony_id), UNIQUE INDEX UNIQ_42791726126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE family (id INT AUTO_INCREMENT NOT NULL, colony_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_A5E6215B96ADBADE (colony_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE family_item (id INT AUTO_INCREMENT NOT NULL, family_id INT DEFAULT NULL, item_id INT DEFAULT NULL, INDEX IDX_6B6C873AC35E566A (family_id), UNIQUE INDEX UNIQ_6B6C873A126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE population (id INT AUTO_INCREMENT NOT NULL, specie_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_B449A008D5436AB7 (specie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE population_item (id INT AUTO_INCREMENT NOT NULL, population_id INT DEFAULT NULL, item_id INT DEFAULT NULL, INDEX IDX_C0C7DA32C955D1E1 (population_id), UNIQUE INDEX UNIQ_C0C7DA32126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE specie (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE specie_item (id INT AUTO_INCREMENT NOT NULL, specie_id INT DEFAULT NULL, item_id INT DEFAULT NULL, INDEX IDX_709556F2D5436AB7 (specie_id), UNIQUE INDEX UNIQ_709556F2126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE colony ADD CONSTRAINT FK_C41C77DCC955D1E1 FOREIGN KEY (population_id) REFERENCES population (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE colony_item ADD CONSTRAINT FK_4279172696ADBADE FOREIGN KEY (colony_id) REFERENCES colony (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE colony_item ADD CONSTRAINT FK_42791726126F525E FOREIGN KEY (item_id) REFERENCES melogram (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B96ADBADE FOREIGN KEY (colony_id) REFERENCES colony (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE family_item ADD CONSTRAINT FK_6B6C873AC35E566A FOREIGN KEY (family_id) REFERENCES family (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE family_item ADD CONSTRAINT FK_6B6C873A126F525E FOREIGN KEY (item_id) REFERENCES melogram (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE population ADD CONSTRAINT FK_B449A008D5436AB7 FOREIGN KEY (specie_id) REFERENCES specie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE population_item ADD CONSTRAINT FK_C0C7DA32C955D1E1 FOREIGN KEY (population_id) REFERENCES population (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE population_item ADD CONSTRAINT FK_C0C7DA32126F525E FOREIGN KEY (item_id) REFERENCES melogram (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE specie_item ADD CONSTRAINT FK_709556F2D5436AB7 FOREIGN KEY (specie_id) REFERENCES specie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE specie_item ADD CONSTRAINT FK_709556F2126F525E FOREIGN KEY (item_id) REFERENCES melogram (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE colony_item DROP FOREIGN KEY FK_4279172696ADBADE');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215B96ADBADE');
        $this->addSql('ALTER TABLE family_item DROP FOREIGN KEY FK_6B6C873AC35E566A');
        $this->addSql('ALTER TABLE colony DROP FOREIGN KEY FK_C41C77DCC955D1E1');
        $this->addSql('ALTER TABLE population_item DROP FOREIGN KEY FK_C0C7DA32C955D1E1');
        $this->addSql('ALTER TABLE population DROP FOREIGN KEY FK_B449A008D5436AB7');
        $this->addSql('ALTER TABLE specie_item DROP FOREIGN KEY FK_709556F2D5436AB7');
        $this->addSql('DROP TABLE colony');
        $this->addSql('DROP TABLE colony_item');
        $this->addSql('DROP TABLE family');
        $this->addSql('DROP TABLE family_item');
        $this->addSql('DROP TABLE population');
        $this->addSql('DROP TABLE population_item');
        $this->addSql('DROP TABLE specie');
        $this->addSql('DROP TABLE specie_item');
    }
}
