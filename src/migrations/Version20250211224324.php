<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250211224324 extends AbstractMigration
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
        $this->addSql('CREATE TABLE conversation (id INT AUTO_INCREMENT NOT NULL, sender_id INT NOT NULL, recipient_id INT NOT NULL, publication_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8A8E26E9F624B39D (sender_id), INDEX IDX_8A8E26E9E92F8F78 (recipient_id), INDEX IDX_8A8E26E938B217A7 (publication_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE import_country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, publication_id INT DEFAULT NULL, url VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_6A2CA10C38B217A7 (publication_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, conversation_id INT NOT NULL, sender_id INT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_read TINYINT(1) NOT NULL, INDEX IDX_B6BD307F9AC0396 (conversation_id), INDEX IDX_B6BD307FF624B39D (sender_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE motorization_type (id INT AUTO_INCREMENT NOT NULL, model_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_3EBF3A237975B7E7 (model_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE publication (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, shop_id INT DEFAULT NULL, brand_id INT NOT NULL, model_id INT NOT NULL, motorization_type_id INT NOT NULL, country_id INT NOT NULL, seller_location_id INT NOT NULL, import_country_id INT DEFAULT NULL, description LONGTEXT NOT NULL, price DOUBLE PRECISION NOT NULL, year INT NOT NULL, image_filenames JSON DEFAULT NULL, video_filename VARCHAR(255) DEFAULT NULL, mileage INT DEFAULT NULL, fuel_type VARCHAR(50) NOT NULL, gearbox VARCHAR(50) NOT NULL, has_warranty TINYINT(1) NOT NULL, warranty_months INT DEFAULT NULL, vehicle_condition VARCHAR(255) NOT NULL, vehicle_equipment JSON DEFAULT NULL, engine_size DOUBLE PRECISION DEFAULT NULL, is_import TINYINT(1) NOT NULL, is_customs_duty_paid TINYINT(1) DEFAULT NULL, import_details LONGTEXT DEFAULT NULL, INDEX IDX_AF3C6779A76ED395 (user_id), INDEX IDX_AF3C67794D16C4DD (shop_id), INDEX IDX_AF3C677944F5D008 (brand_id), INDEX IDX_AF3C67797975B7E7 (model_id), INDEX IDX_AF3C6779223D4DD3 (motorization_type_id), INDEX IDX_AF3C6779F92F3E70 (country_id), INDEX IDX_AF3C6779ABE5F239 (seller_location_id), INDEX IDX_AF3C67793BA50063 (import_country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_F62F176F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sale_status (id INT AUTO_INCREMENT NOT NULL, publication_id INT NOT NULL, sold TINYINT(1) NOT NULL, sale_date DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_F616BDE38B217A7 (publication_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, background_image_file_name VARCHAR(255) DEFAULT NULL, logo_image_file_name VARCHAR(255) NOT NULL, creation_date DATE NOT NULL, address VARCHAR(255) NOT NULL, services JSON DEFAULT NULL, work_hours VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_AC6A4CA2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, name VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, phone_number VARCHAR(20) NOT NULL, gender VARCHAR(10) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wishlist (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_9CE12A31A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wishlist_publications (wishlist_id INT NOT NULL, publication_id INT NOT NULL, INDEX IDX_7DE64B6EFB8E54CD (wishlist_id), INDEX IDX_7DE64B6E38B217A7 (publication_id), PRIMARY KEY(wishlist_id, publication_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car_model ADD CONSTRAINT FK_83EF70E44F5D008 FOREIGN KEY (brand_id) REFERENCES car_brand (id)');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9F624B39D FOREIGN KEY (sender_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9E92F8F78 FOREIGN KEY (recipient_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E938B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id)');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C38B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F9AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE motorization_type ADD CONSTRAINT FK_3EBF3A237975B7E7 FOREIGN KEY (model_id) REFERENCES car_model (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C6779A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C67794D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C677944F5D008 FOREIGN KEY (brand_id) REFERENCES car_brand (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C67797975B7E7 FOREIGN KEY (model_id) REFERENCES car_model (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C6779223D4DD3 FOREIGN KEY (motorization_type_id) REFERENCES motorization_type (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C6779F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C6779ABE5F239 FOREIGN KEY (seller_location_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C67793BA50063 FOREIGN KEY (import_country_id) REFERENCES import_country (id)');
        $this->addSql('ALTER TABLE region ADD CONSTRAINT FK_F62F176F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE sale_status ADD CONSTRAINT FK_F616BDE38B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id)');
        $this->addSql('ALTER TABLE shop ADD CONSTRAINT FK_AC6A4CA2A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE wishlist ADD CONSTRAINT FK_9CE12A31A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE wishlist_publications ADD CONSTRAINT FK_7DE64B6EFB8E54CD FOREIGN KEY (wishlist_id) REFERENCES wishlist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wishlist_publications ADD CONSTRAINT FK_7DE64B6E38B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car_model DROP FOREIGN KEY FK_83EF70E44F5D008');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9F624B39D');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9E92F8F78');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E938B217A7');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C38B217A7');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F9AC0396');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FF624B39D');
        $this->addSql('ALTER TABLE motorization_type DROP FOREIGN KEY FK_3EBF3A237975B7E7');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C6779A76ED395');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C67794D16C4DD');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C677944F5D008');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C67797975B7E7');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C6779223D4DD3');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C6779F92F3E70');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C6779ABE5F239');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C67793BA50063');
        $this->addSql('ALTER TABLE region DROP FOREIGN KEY FK_F62F176F92F3E70');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE sale_status DROP FOREIGN KEY FK_F616BDE38B217A7');
        $this->addSql('ALTER TABLE shop DROP FOREIGN KEY FK_AC6A4CA2A76ED395');
        $this->addSql('ALTER TABLE wishlist DROP FOREIGN KEY FK_9CE12A31A76ED395');
        $this->addSql('ALTER TABLE wishlist_publications DROP FOREIGN KEY FK_7DE64B6EFB8E54CD');
        $this->addSql('ALTER TABLE wishlist_publications DROP FOREIGN KEY FK_7DE64B6E38B217A7');
        $this->addSql('DROP TABLE car_brand');
        $this->addSql('DROP TABLE car_model');
        $this->addSql('DROP TABLE conversation');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE import_country');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE motorization_type');
        $this->addSql('DROP TABLE publication');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE sale_status');
        $this->addSql('DROP TABLE shop');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE wishlist');
        $this->addSql('DROP TABLE wishlist_publications');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
