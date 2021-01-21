<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ArrayFilter;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use App\Entity\Company;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(ArrayFilter::new('company'));
    }

/*    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }*/

/*    public function createIndexQueryBuilder($searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {

        $response = $this->get(User::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response->where("roles NOT LIKE '1'");
        return $response;
/*        $qb = $this->get(User::class)->
            createQueryBuilder('u')
            ->addSelect('c.name')
            ->andWhere('u.isVerified = 0')
            ->join('u.company', 'c')
            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult();
        return $qb;*/
//    }
}
