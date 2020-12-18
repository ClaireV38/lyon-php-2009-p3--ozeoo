<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;
use App\Entity\Company;

class CompanyFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * nb objects to create
     * @var int
     **/
    public const NB_OBJECT = 50;

    /**
     * @var array
     */
    private const PICTURES = ['greeting.jpg','building.jpg','meeting.jpg'];

    public function getDependencies()
    {
        return [UserFixtures::class, CityFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR');
        for ($i = 1; $i <= self::NB_OBJECT; $i++) {
            $company = new Company();
            $company->setUser($this->getReference('comp_user_' . $i));
            $company->setCity($this->getReference('city_' . rand(1, self::NB_OBJECT)));
            $company->setName($faker->company());
            $company->setSiretNb($faker->numerify("##############"));
            $company->setContactEmail($faker->email());
            $company->setApeNb($faker->randomNumber(4, false));
            $company->setPicture(self::PICTURES[rand(0, 2)]);
            $company->setVideo('https://player.vimeo.com/external/372304294.
            sd.mp4?s=68f05e893665288fc91021b717b24292bd326364&profile_id=139&oauth2_token_id=57447761');
            $company->setDescription($faker->text(300));
            $company->setCorporateCulture($faker->paragraph(3));
            $company->setCsr($faker->paragraph(2));
            $manager->persist($company);
            $this->addReference('company_' . $i, $company);
        }
        $manager->flush();
    }
}
