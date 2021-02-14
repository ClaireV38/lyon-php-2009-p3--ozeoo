<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;
use App\Entity\Offer;
use DateTime;
use App\DataFixtures\CompanyFixtures;
use App\DataFixtures\SkillFixtures;

class OfferFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * nb objects to create
     * @var int
     **/
    public const NB_OBJECT = 100;

    public function getDependencies()
    {
        return [UserFixtures::class, ApplicantFixtures::class, SkillFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR');
        $offer1 = new Offer();
        $offer1->setCity($faker->text(20));
        $offer1->setCompany($this->getReference('company_' . 1));
        $offer1->addApplicant($this->getReference('applicant_' . 2));
        $offer1->setTitle($faker->sentence(6, true));
        $offer1->setContractType($faker->sentence(2, true));
        $offer1->setSalary($faker->bothify('????? ??? #### € ???'));
        $offer1->setDuration($faker->sentence(4, true));
        $offer1->setStartDate(
            $faker->dateTimebetween(new DateTime('now'), '2023-00-00 00:00:00')
        );
        $offer1->setCreationDate(new DateTime('now'));
        $offer1->setEndDate(
            $faker->dateTimeBetween($offer1->getStartDate(), '2023-00-00 00:00:00')
        );
        $offer1->setDescription($faker->text(255));
        $offer1->setIsAnonymous(0);
        for ($j = 5; $j <= 10; $j++) {
            $offer1->addHardSkill($this->getReference('hardskill_' . $j));
        }
        for ($j = 100; $j <= 105; $j++) {
            $offer1->addHardSkill($this->getReference('hardskill_' . $j));
        }
        for ($j = 1; $j <= 10; $j++) {
            $offer1->addSoftSkill($this->getReference('softskill_' . $j));
        }
        $manager->persist($offer1);
        $this->addReference('offer_' . 1, $offer1);
        for ($i = 2; $i <= self::NB_OBJECT; $i++) {
            $offer = new Offer();
            $offer->setCity($faker->text(20));
            $offer->setCompany($this->getReference('company_' . rand(1, CompanyFixtures::NB_OBJECT)));
            $offer->setTitle($faker->sentence(6, true));
            $offer->setContractType($faker->sentence(2, true));
            $offer->setSalary($faker->bothify('????? ??? #### € ???'));
            $offer->setDuration($faker->sentence(4, true));
            $offer->setStartDate(
                $faker->dateTimebetween(new DateTime('now'), '2023-00-00 00:00:00')
            );
            $offer->setCreationDate(new DateTime('now'));
            $offer->setEndDate(
                $faker->dateTimeBetween($offer->getStartDate(), '2023-00-00 00:00:00')
            );
            $offer->setDescription($faker->text(255));
            $offer->setIsAnonymous(rand(0, 1));
            for ($j = 1; $j <= 10; $j++) {
                $offer->addHardSkill($this->getReference('hardskill_' . rand(1, SkillFixtures::NB_HARDSKILLS)));
            }
            for ($j = 1; $j <= 10; $j++) {
                $offer->addSoftSkill($this->getReference('softskill_' . rand(1, SkillFixtures::NB_SOFTSKILLS)));
            }
            $manager->persist($offer);
            $this->addReference('offer_' . $i, $offer);
        }
        $manager->flush();
    }
}
