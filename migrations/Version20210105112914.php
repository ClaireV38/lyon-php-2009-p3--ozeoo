<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210105112914 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE applicant DROP FOREIGN KEY FK_CAAD10198BAC62AF');
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094F8BAC62AF');
        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY FK_29D6873E8BAC62AF');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP INDEX IDX_CAAD10198BAC62AF ON applicant');
        $this->addSql('ALTER TABLE applicant ADD city LONGTEXT NOT NULL, DROP city_id');
        $this->addSql('DROP INDEX IDX_4FBF094F8BAC62AF ON company');
        $this->addSql('ALTER TABLE company ADD city LONGTEXT NOT NULL, DROP city_id, CHANGE contact_email contact_email VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_29D6873E8BAC62AF ON offer');
        $this->addSql('ALTER TABLE offer ADD city LONGTEXT NOT NULL, DROP city_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, zipcode INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE applicant ADD city_id INT NOT NULL, DROP city');
        $this->addSql('ALTER TABLE applicant ADD CONSTRAINT FK_CAAD10198BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_CAAD10198BAC62AF ON applicant (city_id)');
        $this->addSql('ALTER TABLE company ADD city_id INT DEFAULT NULL, DROP city, CHANGE contact_email contact_email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_4FBF094F8BAC62AF ON company (city_id)');
        $this->addSql('ALTER TABLE offer ADD city_id INT NOT NULL, DROP city');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873E8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_29D6873E8BAC62AF ON offer (city_id)');
    }
}
