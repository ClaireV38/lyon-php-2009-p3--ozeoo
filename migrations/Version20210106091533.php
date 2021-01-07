<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210106091533 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE applicant_soft_skills (applicant_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_8A133AC597139001 (applicant_id), INDEX IDX_8A133AC55585C142 (skill_id), PRIMARY KEY(applicant_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE applicant_hard_skills (applicant_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_949A6BAF97139001 (applicant_id), INDEX IDX_949A6BAF5585C142 (skill_id), PRIMARY KEY(applicant_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE applicant_soft_skills ADD CONSTRAINT FK_8A133AC597139001 FOREIGN KEY (applicant_id) REFERENCES applicant (id)');
        $this->addSql('ALTER TABLE applicant_soft_skills ADD CONSTRAINT FK_8A133AC55585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE applicant_hard_skills ADD CONSTRAINT FK_949A6BAF97139001 FOREIGN KEY (applicant_id) REFERENCES applicant (id)');
        $this->addSql('ALTER TABLE applicant_hard_skills ADD CONSTRAINT FK_949A6BAF5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('DROP TABLE skill_applicant');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE skill_applicant (skill_id INT NOT NULL, applicant_id INT NOT NULL, INDEX IDX_995C2B445585C142 (skill_id), INDEX IDX_995C2B4497139001 (applicant_id), PRIMARY KEY(skill_id, applicant_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE skill_applicant ADD CONSTRAINT FK_995C2B445585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_applicant ADD CONSTRAINT FK_995C2B4497139001 FOREIGN KEY (applicant_id) REFERENCES applicant (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('DROP TABLE applicant_soft_skills');
        $this->addSql('DROP TABLE applicant_hard_skills');
        $this->addSql('ALTER TABLE applicant CHANGE city_id city_id INT DEFAULT NULL');
    }
}
