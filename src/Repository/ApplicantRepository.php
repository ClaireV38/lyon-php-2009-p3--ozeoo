<?php

namespace App\Repository;

use App\Entity\Applicant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Applicant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Applicant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Applicant[]    findAll()
 * @method Applicant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApplicantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Applicant::class);
    }

//    public function findMatchOffer(array $offer): array
//    {
//        return $this->createQueryBuilder('a')
//            ->innerjoin('a.offer', 'o')
//            ->where('a.exampleField = :val')
//            ->orderBy( 'ASC')
//            ->getQuery()
//            ->getResult()
//            ;
//    }

    // /**
    //  * @return Applicant[] Returns an array of Applicant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Applicant
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
