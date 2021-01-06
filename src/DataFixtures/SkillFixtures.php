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
     * nb softskills to create
     * @var int
     */
    public const NB_HARDSKILLS = 1000;

    /**
     * nb softskills to create
     * @var int
     */
    public const NB_SOFTSKILLS = 100;

    public function getDependencies()
    {
        return [SkillCategoryFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $indexHardSkills = 0;
        $nbHardCategories = count(SkillCategoryFixtures::CATEGORIES) - 1;
        for ($i = 1; $i <= $nbHardCategories; $i++) {
            for ($j = 1; $j <= round(self::NB_HARDSKILLS / $nbHardCategories); $j++) {
                $indexHardSkills++;
                $skill = new Skill();
                $skill->setSkillCategory($this->getReference('skill_category_' . $i));
                $skill->setName($faker->text(100));
                $manager->persist($skill);
                $this->addReference('hardskill_' . $indexHardSkills, $skill);
            }
        }
        for ($j = 1; $j <= self::NB_SOFTSKILLS; $j++) {
            $skill = new Skill();
            $skill->setSkillCategory($this->getReference('skill_category_' . $i));
            $skill->setName($faker->text(100));
            $manager->persist($skill);
            $this->addReference('softskill_' . $j, $skill);
        }
        $manager->flush();
    }
}
