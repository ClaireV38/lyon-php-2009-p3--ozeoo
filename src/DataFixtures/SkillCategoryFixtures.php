<?php

namespace App\DataFixtures;

use App\Entity\SkillCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SkillCategoryFixtures extends Fixture
{

    /**
     * @var array
     */
    public const CATEGORIES = ['marketing','communication','direction d\'entreprise','études, R&D',
        'gestion,finance et administration', 'informatique', 'production industrielle, travaux et chantier',
        'ressources humaines', 'santé, social et culture', 'services techniques', 'soft skills'];

    public function load(ObjectManager $manager)
    {
        foreach (self::CATEGORIES as $key => $category) {
            $skillCategory = new SkillCategory();
            $skillCategory->setName($category);
            $skillCategory->setIsHard(true);
            if ($category === 'soft skills') {
                $skillCategory->setIsHard(false);
            }
            $this->addReference('skill_category_' . ($key + 1), $skillCategory);
            $manager->persist($skillCategory);
        };
        $manager->flush();
    }
}
