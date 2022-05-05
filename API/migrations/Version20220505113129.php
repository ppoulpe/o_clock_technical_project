<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220505113129 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initialize project DB';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE leaderboard (id UUID NOT NULL, username VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, score INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN leaderboard.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN leaderboard.created_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE leaderboard');
    }
}
