<?php

namespace App\Repository;

use App\Entity\Applicant;
use App\Entity\Offer;
use App\Entity\Skill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * @method Offer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offer[]    findAll()
 * @method Offer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OfferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offer::class);
    }

    /**
     * @param Offer $o
     * @return array|int|string
     */
    public function findMatchingApplicantsForOffer(Offer $o)
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('match_hs', 'match_hs');
        $rsm->addScalarResult('match_ss', 'match_ss');
        $rsm->addScalarResult('applicant_id', 'applicant_id');
        $rsm->addScalarResult('firstname', 'firstname');
        $rsm->addScalarResult('personality', 'personality');
        $rsm->addScalarResult('mobility', 'mobility');
        $rsm->addScalarResult('city', 'city');

        $sql = $this->getEntityManager()->createNativeQuery('
        SELECT COUNT(distinct hs.id) as `match_hs`, COUNT(distinct ss.id) as `match_ss`,
         a.id as `applicant_id`, a.firstname, a.personality, a.mobility, a.city
        FROM offer o
            JOIN offer_hard_skills ohs on o.id = ohs.offer_id
            JOIN applicant_hard_skills ahs on ohs.skill_id = ahs.skill_id
            JOIN skill hs on ohs.skill_id = hs.id
            JOIN offer_soft_skills oss on o.id = oss.offer_id
            JOIN applicant_soft_skills ass on oss.skill_id = ass.skill_id
            JOIN skill ss on oss.skill_id = ss.id
            JOIN applicant a on ahs.applicant_id = a.id and ass.applicant_id = a.id
        WHERE o.id = :offer
        GROUP BY a.id
        HAVING `match_hs` >= 5 and `match_ss` >= 5
        ', $rsm);
        $sql->setParameters((array('offer' => $o->getId())));
        return $sql->getArrayResult();
    }

    // /**
    //  * @return Offer[] Returns an array of Offer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Offer
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
