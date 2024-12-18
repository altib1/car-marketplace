<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241218220002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE publication ADD brand_id INT NOT NULL, ADD model_id INT NOT NULL, ADD motorization_type_id INT NOT NULL, DROP brand, DROP model, DROP motorization_type');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C677944F5D008 FOREIGN KEY (brand_id) REFERENCES car_brand (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C67797975B7E7 FOREIGN KEY (model_id) REFERENCES car_model (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C6779223D4DD3 FOREIGN KEY (motorization_type_id) REFERENCES motorization_type (id)');
        $this->addSql('CREATE INDEX IDX_AF3C677944F5D008 ON publication (brand_id)');
        $this->addSql('CREATE INDEX IDX_AF3C67797975B7E7 ON publication (model_id)');
        $this->addSql('CREATE INDEX IDX_AF3C6779223D4DD3 ON publication (motorization_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C677944F5D008');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C67797975B7E7');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C6779223D4DD3');
        $this->addSql('DROP INDEX IDX_AF3C677944F5D008 ON publication');
        $this->addSql('DROP INDEX IDX_AF3C67797975B7E7 ON publication');
        $this->addSql('DROP INDEX IDX_AF3C6779223D4DD3 ON publication');
        $this->addSql('ALTER TABLE publication ADD brand VARCHAR(255) NOT NULL, ADD model VARCHAR(255) NOT NULL, ADD motorization_type VARCHAR(255) NOT NULL, DROP brand_id, DROP model_id, DROP motorization_type_id');
    }
}
