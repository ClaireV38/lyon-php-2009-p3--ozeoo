<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;
use App\Entity\Offer;
use DateTime;
use App\DataFixtures\CompanyFixtures;
use App\DataFixtures\CityFixtures;

class OfferFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * nb objects to create
     * @var int
     **/
    public const NB_OBJECT = 100;

    public function getDependencies()
    {
        return [UserFixtures::class, CityFixtures::class, ApplicantFixtures::class, SkillFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR');
        for ($i = 1; $i <= self::NB_OBJECT; $i++) {
            $offer = new Offer();
            $offer->setCity($this->getReference('city_' . rand(1, CityFixtures::NB_OBJECT)));
            $offer->setCompany($this->getReference('company_' . rand(1, CompanyFixtures::NB_OBJECT)));
            for ($j = 1; $j <= rand(0, 5); $j++) {
                $offer->addApplicant($this->getReference('applicant_' . rand(1, ApplicantFixtures::NB_OBJECT)));
            }
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
                $offer->addSkill($this->getReference('hardskill_' . rand(1, 1000)));
            }
            for ($j = 1; $j <= 10; $j++) {
                $offer->addSkill($this->getReference('softskill_' . rand(1, 100)));
            }
            $manager->persist($offer);
            $this->addReference('offer_' . $i, $offer);
        }
        $manager->flush();
    }
}
