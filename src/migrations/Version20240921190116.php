<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240921190116 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE car_brand (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_model (id INT AUTO_INCREMENT NOT NULL, brand_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_83EF70E44F5D008 (brand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, publication_id INT DEFAULT NULL, url VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_6A2CA10C38B217A7 (publication_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE motorization_type (id INT AUTO_INCREMENT NOT NULL, model_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_3EBF3A237975B7E7 (model_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE publication (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, brand_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price DOUBLE PRECISION NOT NULL, year INT NOT NULL, INDEX IDX_AF3C6779A76ED395 (user_id), INDEX IDX_AF3C677944F5D008 (brand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car_model ADD CONSTRAINT FK_83EF70E44F5D008 FOREIGN KEY (brand_id) REFERENCES car_brand (id)');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C38B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id)');
        $this->addSql('ALTER TABLE motorization_type ADD CONSTRAINT FK_3EBF3A237975B7E7 FOREIGN KEY (model_id) REFERENCES car_model (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C6779A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C677944F5D008 FOREIGN KEY (brand_id) REFERENCES car_brand (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car_model DROP FOREIGN KEY FK_83EF70E44F5D008');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C38B217A7');
        $this->addSql('ALTER TABLE motorization_type DROP FOREIGN KEY FK_3EBF3A237975B7E7');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C6779A76ED395');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C677944F5D008');
        $this->addSql('DROP TABLE car_brand');
        $this->addSql('DROP TABLE car_model');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE motorization_type');
        $this->addSql('DROP TABLE publication');
    }
}
