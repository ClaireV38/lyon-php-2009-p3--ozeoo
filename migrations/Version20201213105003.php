<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201213105003 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE applicant (id INT AUTO_INCREMENT NOT NULL, city_id INT NOT NULL, user_id INT NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, personality LONGTEXT NOT NULL, INDEX IDX_CAAD10198BAC62AF (city_id), UNIQUE INDEX UNIQ_CAAD1019A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, zipcode INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, city_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, siret_nb INT NOT NULL, contact_email VARCHAR(255) NOT NULL, ape_nb INT NOT NULL, picture VARCHAR(500) DEFAULT NULL, video VARCHAR(255) DEFAULT NULL, description LONGTEXT NOT NULL, corporate_culture LONGTEXT NOT NULL, csr LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_4FBF094FA76ED395 (user_id), INDEX IDX_4FBF094F8BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offer (id INT AUTO_INCREMENT NOT NULL, city_id INT NOT NULL, company_id INT NOT NULL, title VARCHAR(255) NOT NULL, contract_type VARCHAR(50) NOT NULL, salary VARCHAR(100) DEFAULT NULL, duration VARCHAR(255) DEFAULT NULL, date DATE NOT NULL, creation_date DATE NOT NULL, end_date DATE DEFAULT NULL, description LONGTEXT NOT NULL, is_anonymous TINYINT(1) NOT NULL, INDEX IDX_29D6873E8BAC62AF (city_id), INDEX IDX_29D6873E979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offer_applicant (offer_id INT NOT NULL, applicant_id INT NOT NULL, INDEX IDX_69686DDD53C674EE (offer_id), INDEX IDX_69686DDD97139001 (applicant_id), PRIMARY KEY(offer_id, applicant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, skill_category_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_5E3DE477AC58042E (skill_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill_applicant (skill_id INT NOT NULL, applicant_id INT NOT NULL, INDEX IDX_995C2B445585C142 (skill_id), INDEX IDX_995C2B4497139001 (applicant_id), PRIMARY KEY(skill_id, applicant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill_offer (skill_id INT NOT NULL, offer_id INT NOT NULL, INDEX IDX_CFE14025585C142 (skill_id), INDEX IDX_CFE140253C674EE (offer_id), PRIMARY KEY(skill_id, offer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill_category (id INT AUTO_INCREMENT NOT NULL, is_hard TINYINT(1) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE applicant ADD CONSTRAINT FK_CAAD10198BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE applicant ADD CONSTRAINT FK_CAAD1019A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873E8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873E979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE offer_applicant ADD CONSTRAINT FK_69686DDD53C674EE FOREIGN KEY (offer_id) REFERENCES offer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offer_applicant ADD CONSTRAINT FK_69686DDD97139001 FOREIGN KEY (applicant_id) REFERENCES applicant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE477AC58042E FOREIGN KEY (skill_category_id) REFERENCES skill_category (id)');
        $this->addSql('ALTER TABLE skill_applicant ADD CONSTRAINT FK_995C2B445585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_applicant ADD CONSTRAINT FK_995C2B4497139001 FOREIGN KEY (applicant_id) REFERENCES applicant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_offer ADD CONSTRAINT FK_CFE14025585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_offer ADD CONSTRAINT FK_CFE140253C674EE FOREIGN KEY (offer_id) REFERENCES offer (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offer_applicant DROP FOREIGN KEY FK_69686DDD97139001');
        $this->addSql('ALTER TABLE skill_applicant DROP FOREIGN KEY FK_995C2B4497139001');
        $this->addSql('ALTER TABLE applicant DROP FOREIGN KEY FK_CAAD10198BAC62AF');
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094F8BAC62AF');
        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY FK_29D6873E8BAC62AF');
        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY FK_29D6873E979B1AD6');
        $this->addSql('ALTER TABLE offer_applicant DROP FOREIGN KEY FK_69686DDD53C674EE');
        $this->addSql('ALTER TABLE skill_offer DROP FOREIGN KEY FK_CFE140253C674EE');
        $this->addSql('ALTER TABLE skill_applicant DROP FOREIGN KEY FK_995C2B445585C142');
        $this->addSql('ALTER TABLE skill_offer DROP FOREIGN KEY FK_CFE14025585C142');
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE477AC58042E');
        $this->addSql('ALTER TABLE applicant DROP FOREIGN KEY FK_CAAD1019A76ED395');
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094FA76ED395');
        $this->addSql('DROP TABLE applicant');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE offer');
        $this->addSql('DROP TABLE offer_applicant');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE skill_applicant');
        $this->addSql('DROP TABLE skill_offer');
        $this->addSql('DROP TABLE skill_category');
        $this->addSql('DROP TABLE user');
    }
}
