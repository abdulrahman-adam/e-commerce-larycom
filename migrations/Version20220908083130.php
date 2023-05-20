<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220908083130 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accessoires (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, name VARCHAR(55) NOT NULL, category VARCHAR(55) NOT NULL, price DOUBLE PRECISION NOT NULL, picture VARCHAR(255) DEFAULT NULL, INDEX IDX_B661BA4F4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bagages (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, name VARCHAR(55) NOT NULL, category VARCHAR(55) NOT NULL, price DOUBLE PRECISION NOT NULL, picture VARCHAR(255) DEFAULT NULL, INDEX IDX_767B07B74584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chaussures (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, name VARCHAR(55) NOT NULL, category VARCHAR(55) NOT NULL, price DOUBLE PRECISION NOT NULL, picture VARCHAR(255) DEFAULT NULL, INDEX IDX_75261D944584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parfums (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, name VARCHAR(55) NOT NULL, category VARCHAR(55) NOT NULL, price DOUBLE PRECISION NOT NULL, picture VARCHAR(255) DEFAULT NULL, INDEX IDX_6496570D4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sport (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, name VARCHAR(55) NOT NULL, category VARCHAR(55) NOT NULL, price DOUBLE PRECISION NOT NULL, picture VARCHAR(255) DEFAULT NULL, INDEX IDX_1A85EFD24584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vetements (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, name VARCHAR(55) NOT NULL, category VARCHAR(55) NOT NULL, price DOUBLE PRECISION NOT NULL, picture VARCHAR(255) DEFAULT NULL, INDEX IDX_10E9A46C4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accessoires ADD CONSTRAINT FK_B661BA4F4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE bagages ADD CONSTRAINT FK_767B07B74584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE chaussures ADD CONSTRAINT FK_75261D944584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE parfums ADD CONSTRAINT FK_6496570D4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE sport ADD CONSTRAINT FK_1A85EFD24584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE vetements ADD CONSTRAINT FK_10E9A46C4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accessoires DROP FOREIGN KEY FK_B661BA4F4584665A');
        $this->addSql('ALTER TABLE bagages DROP FOREIGN KEY FK_767B07B74584665A');
        $this->addSql('ALTER TABLE chaussures DROP FOREIGN KEY FK_75261D944584665A');
        $this->addSql('ALTER TABLE parfums DROP FOREIGN KEY FK_6496570D4584665A');
        $this->addSql('ALTER TABLE sport DROP FOREIGN KEY FK_1A85EFD24584665A');
        $this->addSql('ALTER TABLE vetements DROP FOREIGN KEY FK_10E9A46C4584665A');
        $this->addSql('DROP TABLE accessoires');
        $this->addSql('DROP TABLE bagages');
        $this->addSql('DROP TABLE chaussures');
        $this->addSql('DROP TABLE parfums');
        $this->addSql('DROP TABLE sport');
        $this->addSql('DROP TABLE vetements');
    }
}
