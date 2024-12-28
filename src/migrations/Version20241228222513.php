<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241228222513 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE wishlist_publications (wishlist_id INT NOT NULL, publication_id INT NOT NULL, INDEX IDX_7DE64B6EFB8E54CD (wishlist_id), INDEX IDX_7DE64B6E38B217A7 (publication_id), PRIMARY KEY(wishlist_id, publication_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE wishlist_publications ADD CONSTRAINT FK_7DE64B6EFB8E54CD FOREIGN KEY (wishlist_id) REFERENCES wishlist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wishlist_publications ADD CONSTRAINT FK_7DE64B6E38B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C6779FB8E54CD');
        $this->addSql('DROP INDEX IDX_AF3C6779FB8E54CD ON publication');
        $this->addSql('ALTER TABLE publication DROP wishlist_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wishlist_publications DROP FOREIGN KEY FK_7DE64B6EFB8E54CD');
        $this->addSql('ALTER TABLE wishlist_publications DROP FOREIGN KEY FK_7DE64B6E38B217A7');
        $this->addSql('DROP TABLE wishlist_publications');
        $this->addSql('ALTER TABLE publication ADD wishlist_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C6779FB8E54CD FOREIGN KEY (wishlist_id) REFERENCES wishlist (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_AF3C6779FB8E54CD ON publication (wishlist_id)');
    }
}
