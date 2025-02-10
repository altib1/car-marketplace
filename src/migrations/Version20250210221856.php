<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250210221856 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE import_country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE publication ADD import_country_id INT DEFAULT NULL, ADD is_import TINYINT(1) NOT NULL, ADD is_customs_duty_paid TINYINT(1) DEFAULT NULL, ADD import_details LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C67793BA50063 FOREIGN KEY (import_country_id) REFERENCES import_country (id)');
        $this->addSql('CREATE INDEX IDX_AF3C67793BA50063 ON publication (import_country_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C67793BA50063');
        $this->addSql('DROP TABLE import_country');
        $this->addSql('DROP INDEX IDX_AF3C67793BA50063 ON publication');
        $this->addSql('ALTER TABLE publication DROP import_country_id, DROP is_import, DROP is_customs_duty_paid, DROP import_details');
    }
}
