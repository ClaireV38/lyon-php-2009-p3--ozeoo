<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;
use App\Entity\Offer;
use Symfony\Component\Validator\Constraints\DateTime;

class OfferFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * nb objects to create
     * @var int
     **/
    private const NB_OBJECT = 100;

    public function getDependencies()
    {
        return [UserFixtures::class, CityFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR');
        for ($i = 1; $i <= self::NB_OBJECT; $i++) {
            $offer = new Offer();
            $offer->setCity($this->getReference('city_' . rand(1, 50)));
            $offer->setCompany($this->getReference('company_' . rand(1, 50)));
            for ($j = 1; $j <= rand(0, 5); $j++) {
                $offer->addApplicant($this->getReference('applicant_' . rand(1, 50)));
            }
            $offer->setTitle($faker->sentence(6, true));
            $offer->setContractType($faker->sentence(2, true));
            $offer->setSalary($faker->bothify('????? ??? #### € ???'));
            $offer->setDuration($faker->sentence(4, true));
            $offer->setStartDate(
                $faker->dateTimebetween(new DateTime('now'), '2023-00-00 00:00:00')
            );
            $offer->setCreationDate('now');
            $offer->setEndDate(
                $faker->dateTimeBetween($offer->getStartDate(), '2023-00-00 00:00:00')
            );
            $offer->setDescription($faker->text(255));
            $offer->setIsAnonymous(rand(0, 1));
            $manager->persist($offer);
            $this->addReference('offer_' . $i, $offer);
        }
        $manager->flush();
    }
}
