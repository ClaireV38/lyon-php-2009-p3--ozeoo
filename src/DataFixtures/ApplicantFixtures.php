<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;
use App\Entity\Applicant;

class ApplicantFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * nb objects to create
     * @var int
     **/
    public const NB_OBJECT = 50;

    public function getDependencies()
    {
        return [UserFixtures::class, CityFixtures::class, SkillFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR');
        for ($i = 1; $i <= self::NB_OBJECT; $i++) {
            $applicant = new Applicant();
            $applicant->setUser($this->getReference('appl_user_' . $i));
            $applicant->setCity($this->getReference('city_' . rand(1, self::NB_OBJECT)));
            $applicant->setFirstname($faker->firstName());
            $applicant->setLastname($faker->lastName());
            $applicant->setPersonality($faker->text(100));
            $applicant->setMobility($faker->text(100));
            for ($j = 1; $j <= 10; $j++) {
                $applicant->addSkill($this->getReference('hardskill_' . rand(1, 1000)));
            }
            for ($j = 1; $j <= 10; $j++) {
                $applicant->addSkill($this->getReference('softskill_' . rand(1, 100)));
            }
            $manager->persist($applicant);
            $this->addReference('applicant_' . $i, $applicant);
        }
        $manager->flush();
    }
}
