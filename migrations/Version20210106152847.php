<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210106152847 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE offer_soft_skills (offer_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_1B842F2453C674EE (offer_id), INDEX IDX_1B842F245585C142 (skill_id), PRIMARY KEY(offer_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offer_hard_skills (offer_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_50D7E4E53C674EE (offer_id), INDEX IDX_50D7E4E5585C142 (skill_id), PRIMARY KEY(offer_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE offer_soft_skills ADD CONSTRAINT FK_1B842F2453C674EE FOREIGN KEY (offer_id) REFERENCES offer (id)');
        $this->addSql('ALTER TABLE offer_soft_skills ADD CONSTRAINT FK_1B842F245585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE offer_hard_skills ADD CONSTRAINT FK_50D7E4E53C674EE FOREIGN KEY (offer_id) REFERENCES offer (id)');
        $this->addSql('ALTER TABLE offer_hard_skills ADD CONSTRAINT FK_50D7E4E5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('DROP TABLE skill_offer');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE skill_offer (skill_id INT NOT NULL, offer_id INT NOT NULL, INDEX IDX_CFE140253C674EE (offer_id), INDEX IDX_CFE14025585C142 (skill_id), PRIMARY KEY(skill_id, offer_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE skill_offer ADD CONSTRAINT FK_CFE140253C674EE FOREIGN KEY (offer_id) REFERENCES offer (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_offer ADD CONSTRAINT FK_CFE14025585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('DROP TABLE offer_soft_skills');
        $this->addSql('DROP TABLE offer_hard_skills');
    }
}
