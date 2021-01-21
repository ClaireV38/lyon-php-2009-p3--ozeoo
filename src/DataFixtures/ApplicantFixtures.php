<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;
use App\Entity\Applicant;
use App\DataFixtures\CompanyFixtures;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\SkillFixtures;

class ApplicantFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * nb objects to create
     * @var int
     **/
    public const NB_OBJECT = 50;

    public function getDependencies()
    {
        return [UserFixtures::class, SkillFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR');
        $applicant1 = new Applicant();
        $applicant1->setUser($this->getReference('appl_user_' . 1));
        $applicant1->setCity($faker->text(20));
        $applicant1->setFirstname($faker->firstName());
        $applicant1->setLastname($faker->lastName());
        $applicant1->setPersonality($faker->text(100));
        $applicant1->setMobility($faker->text(100));
        for ($j = 1; $j <= 10; $j++) {
            $applicant1->addHardSkill($this->getReference('hardskill_' . $j));
        }
        for ($j = 1; $j <= 10; $j++) {
            $applicant1->addSoftSkill($this->getReference('softskill_' . $j));
        }
        $manager->persist($applicant1);
        $this->addReference('applicant_' . 1, $applicant1);
        $applicant2 = new Applicant();
        $applicant2->setUser($this->getReference('appl_user_' . 2));
        $applicant2->setCity($faker->text(20));
        $applicant2->setFirstname($faker->firstName());
        $applicant2->setLastname($faker->lastName());
        $applicant2->setPersonality($faker->text(100));
        $applicant2->setMobility($faker->text(100));
        for ($j = 5; $j <= 10; $j++) {
            $applicant2->addHardSkill($this->getReference('hardskill_' . $j));
        }
        for ($j = 5; $j <= 10; $j++) {
            $applicant2->addSoftSkill($this->getReference('softskill_' . $j));
        }
        $manager->persist($applicant2);
        $this->addReference('applicant_' . 2, $applicant2);
        for ($i = 3; $i <= self::NB_OBJECT; $i++) {
            $applicant = new Applicant();
            $applicant->setUser($this->getReference('appl_user_' . $i));
            $applicant->setCity($faker->text(20));
            $applicant->setFirstname($faker->firstName());
            $applicant->setLastname($faker->lastName());
            $applicant->setPersonality($faker->text(100));
            $applicant->setMobility($faker->text(100));
            for ($j = 1; $j <= 10; $j++) {
                $applicant->addHardSkill($this->getReference('hardskill_' . rand(1, SkillFixtures::NB_HARDSKILLS)));
            }
            for ($j = 1; $j <= 10; $j++) {
                $applicant->addSoftSkill($this->getReference('softskill_' . rand(1, SkillFixtures::NB_SOFTSKILLS)));
            }
            $manager->persist($applicant);
            $this->addReference('applicant_' . $i, $applicant);
        }
        $manager->flush();
    }
}
