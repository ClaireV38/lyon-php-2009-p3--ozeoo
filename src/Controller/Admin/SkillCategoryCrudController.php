<?php

namespace App\Controller\Admin;

use App\Entity\SkillCategory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;

class SkillCategoryCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return SkillCategory::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setEntityLabelInPlural('Catégories des compétences')
            ->setEntityLabelInSingular('une catégories');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom de la catégorie'),
            BooleanField::new('isHard', 'Compétences Techniques'),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('isHard')
            ;
    }
}
