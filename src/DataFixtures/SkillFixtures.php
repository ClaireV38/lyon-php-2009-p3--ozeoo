<?php

namespace App\DataFixtures;

use App\Entity\Offer;
use App\Entity\SkillCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Skill;
use Faker;

class SkillFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * nb objects to create
     * @var int
     **/
    private const NB_OBJECT = 50;

    public function getDependencies()
    {
        return [SkillCategoryFixtures::class, ApplicantFixtures::class, OfferFixtures::class];
    }


    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR');
        for ($i = 1; $i <= 11; $i++) {
            for ($j = 1; $j <= rand(50, 150); $j++) {
                $skill = new Skill();
                $skill->setSkillCategory($this->getReference('skill_category_' . $i));
                $skill->setName($faker->text(100));
                $manager->persist($skill);
            }
        }
        $manager->flush();
    }
}
