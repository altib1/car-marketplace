<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250121221402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C6779F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C6779ABE5F239 FOREIGN KEY (seller_location_id) REFERENCES region (id)');
        $this->addSql('CREATE INDEX IDX_AF3C6779F92F3E70 ON publication (country_id)');
        $this->addSql('CREATE INDEX IDX_AF3C6779ABE5F239 ON publication (seller_location_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C6779F92F3E70');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C6779ABE5F239');
        $this->addSql('DROP INDEX IDX_AF3C6779F92F3E70 ON publication');
        $this->addSql('DROP INDEX IDX_AF3C6779ABE5F239 ON publication');
    }
}
