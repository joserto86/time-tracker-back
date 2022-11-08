<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221108091527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app_user RENAME INDEX uniq_880e0d76f85e0677 TO UNIQ_88BDF3E9F85E0677');
        $this->addSql('ALTER TABLE app_user_instance ADD username VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE app_user_instance CHANGE COLUMN token token VARCHAR(255) NULL');
        $this->addSql('ALTER TABLE app_user_instance RENAME INDEX idx_d690b6d83a51721d TO IDX_38C068723A51721D');
        $this->addSql('ALTER TABLE app_user_instance RENAME INDEX idx_d690b6d893fa8d TO IDX_38C068724A3353D8');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app_user_instance DROP username');
        $this->addSql('ALTER TABLE app_user_instance CHANGE COLUMN token token VARCHAR(255) NOT NULL DEFAULT ""');
        $this->addSql('ALTER TABLE app_user_instance RENAME INDEX idx_38c068723a51721d TO IDX_D690B6D83A51721D');
        $this->addSql('ALTER TABLE app_user_instance RENAME INDEX idx_38c068724a3353d8 TO IDX_D690B6D893FA8D');
        $this->addSql('ALTER TABLE app_user RENAME INDEX uniq_88bdf3e9f85e0677 TO UNIQ_880E0D76F85E0677');
    }
}
