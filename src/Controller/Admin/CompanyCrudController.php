<?php

namespace App\Controller\Admin;

use App\Entity\Company;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class CompanyCrudController extends AbstractCrudController
{
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public static function getEntityFqcn(): string
    {
        return Company::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('name'),
            TextField::new('siretNb'),
            TextField::new('apeNb'),
            BooleanField::new('isVerified')
        ];
    }
    public function configureActions(Actions $actions): Actions
    {
        $activeCompany = Action::new('activateCompany', 'Activate', 'fa fa-file-invoice')
            ->linkToCrudAction('activateCompany');
        return $actions
            // ...
            ->add(Crud::PAGE_EDIT, $activeCompany);
    }

    public function activateCompany(AdminContext $context)
    {
        $company = $context->getEntity()->getInstance();
        $user = $company->getUser();
        $user->setIsVerified('true');
        $this->em->persist($user);
        $this->em->flush();

        return $this->redirectToRoute('easyadmin', array(
            'action' => 'edit',
            'id' => $company->getId(),
            'entity' => $company
        ));
        // add your logic here...
    }
}
