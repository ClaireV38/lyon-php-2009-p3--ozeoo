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
        for ($i = 1; $i <= self::NB_OBJECT; $i++) {
            $applicant = new Applicant();
            $applicant->setUser($this->getReference('appl_user_' . $i));
            $applicant->setCity($faker->text(20));
            $applicant->setFirstname($faker->firstName());
            $applicant->setLastname($faker->lastName());
            $applicant->setPersonality($faker->text(100));
            $applicant->setMobility($faker->text(100));
            for ($j = 1; $j <= 10; $j++) {
                $applicant->addSkill($this->getReference('hardskill_' . rand(1, SkillFixtures::NB_HARDSKILLS)));
            }
            for ($j = 1; $j <= 10; $j++) {
                $applicant->addSkill($this->getReference('softskill_' . rand(1, SkillFixtures::NB_SOFTSKILLS)));
            }
            $manager->persist($applicant);
            $this->addReference('applicant_' . $i, $applicant);
        }
        $manager->flush();
    }
}
