<?php

namespace App\Repository;

use App\Entity\Applicant;
use App\Entity\Offer;
use App\Entity\Skill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Skill|null find($id, $lockMode = null, $lockVersion = null)
 * @method Skill|null findOneBy(array $criteria, array $orderBy = null)
 * @method Skill[]    findAll()
 * @method Skill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Skill::class);
    }

    /**
     * @param Offer $offer
     * @param Applicant $applicant
     * @return int|mixed|string
     */
    public function findMatchHardSkills(Offer $offer, Applicant $applicant)
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.hardOffers', 'ho', 'WITH', 'ho IN (:offer)')
            ->innerJoin('s.hardApplicants', 'ha', 'WITH', 'ha IN (:applicant)')
            ->setParameter('offer', $offer)
            ->setParameter('applicant', $applicant)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param Offer $offer
     * @param Applicant $applicant
     * @return int|mixed|string
     */
    public function findMatchSoftSkills(Offer $offer, Applicant $applicant)
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.softOffers', 'so', 'WITH', 'so IN (:offer)')
            ->innerJoin('s.softApplicants', 'sa', 'WITH', 'sa IN (:applicant)')
            ->setParameter('offer', $offer)
            ->setParameter('applicant', $applicant)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param Offer $offer
     * @param Applicant $applicant
     * @return int|mixed|string
     */
    public function findMatchingSkills(Offer $offer, Applicant $applicant)
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.hardApplicants', 'aps')
            ->innerJoin('s.hardOffers', 'hos')
            ->innerJoin('s.softApplicants', 'sas')
            ->innerJoin('s.softOffers', 'sos')
            ->where('aps = :appl')
            ->where('hos = :offr')
            ->andWhere('sas = :appl')
            ->andWhere('sos = :offr')
            ->setParameter('appl', $applicant)
            ->setParameter('offr', $offer)
            ->getQuery()
            ->getResult()
            ;
    }
//    /**
//     * @param Offer $offer
//     * @param Applicant $applicant
//     * @return int|mixed|string
//     */
//    public function findMatchSoftSkills(Offer $offer, Applicant $applicant)
//    {
//        return $this->createQueryBuilder('s')
//            ->join('s.softOffers', 'o', 'WITH', 'o IN (:offer)')
//            ->join('s.softApplicants', 'a', 'WITH', 'a IN (:applicant)')
//            ->setParameter('offer', $offer )
//            ->setParameter('applicant', $applicant)
//            ->getQuery()
//            ->getResult()
//            ;
//    }

    // /**
    //  * @return Skill[] Returns an array of Skill objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Skill
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
