<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200229211848 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add stub melogram';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("INSERT INTO melogram SET melogram.name = 'First Melogram', file = ''");
        $this->addSql("INSERT INTO melogram SET melogram.name = 'Second Melogram', file = ''");
        $this->addSql("INSERT INTO melogram SET melogram.name = 'Third Melogram', file = ''");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('TRUNCATE melogram');
    }
}
