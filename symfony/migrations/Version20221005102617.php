<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221005102617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE app_user_instance (id INT AUTO_INCREMENT NOT NULL, instance_id INT NOT NULL, app_user_id INT NOT NULL, token VARCHAR(255) NOT NULL, INDEX IDX_D690B6D83A51721D (instance_id), INDEX IDX_D690B6D893FA8D (app_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE instance (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE app_user_instance ADD CONSTRAINT FK_D690B6D83A51721D FOREIGN KEY (instance_id) REFERENCES instance (id)');
        $this->addSql('ALTER TABLE app_user_instance ADD CONSTRAINT FK_D690B6D893FA8D FOREIGN KEY (app_user_id) REFERENCES `app_user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app_user_instance DROP FOREIGN KEY FK_D690B6D83A51721D');
        $this->addSql('ALTER TABLE app_user_instance DROP FOREIGN KEY FK_D690B6D893FA8D');
        $this->addSql('DROP TABLE app_user_instance');
        $this->addSql('DROP TABLE instance');
    }
}
