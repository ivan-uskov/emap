<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200303203129 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE attribute (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE melogram_attribute (id INT AUTO_INCREMENT NOT NULL, melogram_id INT DEFAULT NULL, attribute_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_33869AAB8870D6E0 (melogram_id), INDEX IDX_33869AABB6E62EFA (attribute_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE melogram_attribute ADD CONSTRAINT FK_33869AAB8870D6E0 FOREIGN KEY (melogram_id) REFERENCES melogram (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE melogram_attribute ADD CONSTRAINT FK_33869AABB6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE melogram_attribute DROP FOREIGN KEY FK_33869AABB6E62EFA');
        $this->addSql('DROP TABLE attribute');
        $this->addSql('DROP TABLE melogram_attribute');
    }
}
