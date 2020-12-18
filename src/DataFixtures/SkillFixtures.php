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
     * @var int
     */
    private $nbSkills;

    public function getDependencies()
    {
        return [SkillCategoryFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $nbSkills = 0;
        for ($i = 1; $i <= 10; $i++) {
            for ($j = 1; $j <= 100; $j++) {
                $nbSkills++;
                $skill = new Skill();
                $skill->setSkillCategory($this->getReference('skill_category_' . $i));
                $skill->setName($faker->text(100));
                $manager->persist($skill);
                $this->addReference('hardskill_' . $nbSkills, $skill);
            }
        }
        for ($j = 1; $j <= 100; $j++) {
            $nbSkills++;
            $skill = new Skill();
            $skill->setSkillCategory($this->getReference('skill_category_' . ($i + 1)));
            $skill->setName($faker->text(100));
            $manager->persist($skill);
            $this->addReference('softskill_' . $j, $skill);
        }
        $manager->flush();
    }
}
