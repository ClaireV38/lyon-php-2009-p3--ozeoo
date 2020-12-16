<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use App\Entity\City;

class CityFixtures extends Fixture
{
    /**
     * nb objects to create
     * @var int
     */
    private const NB_OBJECT = 50;

    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR');
        for ($i = 1; $i <= self::NB_OBJECT; $i++) {
            $city = new City();
            $city->setName($faker->city());
            $city->setZipcode(intval($faker->postcode()));
            $manager->persist($city);
            $this->addReference('city_' . $i, $city);
        }

        $manager->flush();
    }
}
