<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201229131809 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
//        $this->addSql('ALTER TABLE applicant ADD mobility LONGTEXT DEFAULT NULL, CHANGE city_id city_id INT NOT NULL');
        $this->addSql('ALTER TABLE company CHANGE siret_nb siret_nb VARCHAR(15) NOT NULL');
//        $this->addSql('ALTER TABLE offer CHANGE date start_date DATE NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
//        $this->addSql('ALTER TABLE applicant DROP mobility, CHANGE city_id city_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE company CHANGE siret_nb siret_nb INT NOT NULL');
//        $this->addSql('ALTER TABLE offer CHANGE start_date date DATE NOT NULL');
    }
}
