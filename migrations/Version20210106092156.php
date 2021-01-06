<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210106092156 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE applicant DROP FOREIGN KEY FK_CAAD10198BAC62AF');
        $this->addSql('DROP INDEX IDX_CAAD10198BAC62AF ON applicant');
        $this->addSql('ALTER TABLE applicant ADD city VARCHAR(100) NOT NULL, DROP city_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE applicant ADD city_id INT NOT NULL, DROP city');
        $this->addSql('ALTER TABLE applicant ADD CONSTRAINT FK_CAAD10198BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_CAAD10198BAC62AF ON applicant (city_id)');
    }
}
