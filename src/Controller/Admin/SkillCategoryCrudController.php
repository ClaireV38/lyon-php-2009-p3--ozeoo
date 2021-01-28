<?php

namespace App\Controller\Admin;

use App\Entity\SkillCategory;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\RedirectResponse;

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

/*    public function configureActions(Actions $actions): Actions
    {
        $setHard = Action::new('setHard', 'Set Hard', 'fa fa-toggle-on')
            ->linkToCrudAction('setHard');
        return $actions
            ->add(Crud::PAGE_EDIT, $setHard);
    }

    public function setHard(AdminContext $context): RedirectResponse
    {
        $setHard = $context->getEntity()->getInstance();
        $skillCategory = $setHard->getName();
        $skillCategory->setIsHard('1');
        $this->emi->persist($skillCategory);
        $this->emi->flush();

        $url = $this->adminUrlGenerator
            ->setController(SkillCategoryCrudController::class)
            ->setAction('edit')
            ->generateUrl();
        return $this->redirect($url);
    }*/
}
