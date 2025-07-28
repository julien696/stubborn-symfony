<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250725134944 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sweatshirt_size (id INT AUTO_INCREMENT NOT NULL, sweatshirt_id INT NOT NULL, size_id INT NOT NULL, stock INT NOT NULL, INDEX IDX_136249E2A143AB7B (sweatshirt_id), INDEX IDX_136249E2498DA827 (size_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sweatshirt_size ADD CONSTRAINT FK_136249E2A143AB7B FOREIGN KEY (sweatshirt_id) REFERENCES sweatshirt (id)');
        $this->addSql('ALTER TABLE sweatshirt_size ADD CONSTRAINT FK_136249E2498DA827 FOREIGN KEY (size_id) REFERENCES size (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sweatshirt_size DROP FOREIGN KEY FK_136249E2A143AB7B');
        $this->addSql('ALTER TABLE sweatshirt_size DROP FOREIGN KEY FK_136249E2498DA827');
        $this->addSql('DROP TABLE sweatshirt_size');
    }
}
