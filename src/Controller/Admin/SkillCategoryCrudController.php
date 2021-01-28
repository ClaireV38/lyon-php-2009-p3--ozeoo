<?php

namespace App\Controller\Admin;

use App\Entity\SkillCategory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SkillCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SkillCategory::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
        ];
    }
}
