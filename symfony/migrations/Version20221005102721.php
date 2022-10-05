<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221005102721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('INSERT INTO instance(url) VALUES (\'https://git.irontec.com\')');
        $this->addSql('INSERT INTO instance(url) VALUES (\'https://gitlab.com\')');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('TRUNCATE TABLE instance');
    }
}
