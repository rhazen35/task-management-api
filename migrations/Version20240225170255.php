<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240225170255 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add the task table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE task (id BINARY(16) NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, status VARCHAR(255) NOT NULL, assignee BINARY(16) DEFAULT NULL, INDEX IDX_527EDB257C9DFC0C (assignee), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB257C9DFC0C FOREIGN KEY (assignee) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB257C9DFC0C');
        $this->addSql('DROP TABLE task');
    }
}
