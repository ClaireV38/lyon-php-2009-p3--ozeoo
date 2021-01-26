<?php

namespace App\Controller\Admin;

use App\Entity\Company;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CompanyCrudController extends AbstractCrudController
{
    private EntityManagerInterface $emi;
    private AdminUrlGenerator $adminUrlGenerator;

    public function __construct(EntityManagerInterface $emi, AdminUrlGenerator $adminUrlGenerator)
    {
        $this->emi = $emi;
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    public static function getEntityFqcn(): string
    {
        return Company::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom de l\'entreprise'),
            TextField::new('siretNb', 'Numéro Siret'),
            TextField::new('apeNb', 'Numéro APE'),
            BooleanField::new('isVerified', 'Vérifié')->setFormTypeOption('disabled', 'disabled'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $activeCompany = Action::new('activateCompany', 'Vérifier', 'fa fa-toggle-on')
            ->linkToCrudAction('activateCompany');
        $desactivateCompany = Action::new('desactivateCompany', 'Enlever vérification', 'fa fa-toggle-off')
            ->linkToCrudAction('desactivateCompany');
        return $actions
            // ...
            ->add(Crud::PAGE_EDIT, $activeCompany)
            ->add(Crud::PAGE_EDIT, $desactivateCompany);
    }

    public function activateCompany(AdminContext $context): RedirectResponse
    {
        $company = $context->getEntity()->getInstance();
        $user = $company->getUser();
        $user->setIsVerified('1');
        $this->emi->persist($user);
        $this->emi->flush();
        $this->addFlash('success', 'Entreprise Vérifié');

            $url = $this->adminUrlGenerator
            ->setController(CompanyCrudController::class)
            ->setAction('edit')
            ->generateUrl();
        return $this->redirect($url);
    }

    public function desactivateCompany(AdminContext $context): RedirectResponse
    {
        $company = $context->getEntity()->getInstance();
        $user = $company->getUser();
        $user->setIsVerified('0');
        $this->emi->persist($user);
        $this->emi->flush();
        $this->addFlash('success', 'Entreprise non vérifié');

            $url = $this->adminUrlGenerator
            ->setController(CompanyCrudController::class)
            ->setAction('edit')
            ->generateUrl();
        return $this->redirect($url);
    }

    public function activateFilter(AdminContext $context): self
    {
        $company = $context->getEntity()->getInstance();
        $user = $company->getUser();
        $user->$company->getIsVerified();
        return $this;
    }
}
