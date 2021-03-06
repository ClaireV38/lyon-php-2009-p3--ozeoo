<?php

namespace App\Repository;

use App\Entity\Applicant;
use App\Entity\Offer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

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

    public function findMatchingOffersForApplicant(Applicant $applicant): array
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('match_hs', 'match_hs');
        $rsm->addScalarResult('match_ss', 'match_ss');
        $rsm->addScalarResult('offer_id', 'offer_id');
        $rsm->addScalarResult('title', 'offer_title');
        $rsm->addScalarResult('contract_type', 'contract_type');
        $rsm->addScalarResult('creation_date', 'creation_date');
        $rsm->addScalarResult('start_date', 'start_date');
        $rsm->addScalarResult('city', 'city');
        $rsm->addScalarResult('id', 'id');
        $rsm->addScalarResult('company_id', 'company_id');



        $sql = $this->getEntityManager()->createNativeQuery('
        SELECT COUNT(distinct hs.id) as `match_hs`, COUNT(distinct ss.id) as `match_ss`, 
            o.id as `offer_id`, o.title, o.contract_type, o.creation_date, o.start_date, o.city, o.id, o.company_id
        FROM applicant a
            JOIN applicant_hard_skills ahs on a.id = ahs.applicant_id
            JOIN offer_hard_skills ohs on ahs.skill_id = ohs.skill_id
            JOIN skill hs on ahs.skill_id = hs.id
            JOIN applicant_soft_skills ass on a.id = ass.applicant_id
            JOIN offer_soft_skills oss on ass.skill_id = oss.skill_id
            JOIN skill ss on ass.skill_id = ss.id
            JOIN offer o on ohs.offer_id = o.id and oss.offer_id = o.id
        WHERE a.id = :applicant
        GROUP BY o.id
        HAVING `match_hs` >= 5 and `match_ss` >= 5
        ORDER BY o.id DESC 
        ', $rsm);
        $sql->setParameters((array('applicant' => $applicant->getId())));
        return $sql->getArrayResult();
    }

    public function findMatchingOffersForApplicantOrderByStartDate(
        Applicant $applicant,
        string $searchTitle,
        string $searchCompany
    ): array {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('offer_id', 'offer_id');

        $sql = $this->getEntityManager()->createNativeQuery('
        SELECT COUNT(distinct hs.id) as `match_hs`, COUNT(distinct ss.id) as `match_ss`, 
            o.id as `offer_id`, o.title, o.contract_type, o.creation_date,
             o.start_date, o.city, o.id, o.company_id, c.name
        FROM applicant a
            JOIN applicant_hard_skills ahs on a.id = ahs.applicant_id
            JOIN offer_hard_skills ohs on ahs.skill_id = ohs.skill_id
            JOIN skill hs on ahs.skill_id = hs.id
            JOIN applicant_soft_skills ass on a.id = ass.applicant_id
            JOIN offer_soft_skills oss on ass.skill_id = oss.skill_id
            JOIN skill ss on ass.skill_id = ss.id
            JOIN offer o on ohs.offer_id = o.id and oss.offer_id = o.id
            JOIN company c on c.id = o.company_id
        WHERE a.id = :applicant
        GROUP BY o.id
        HAVING `match_hs` >= 5 and `match_ss` >= 5 and o.title like :searchTitle and c.name like :searchCompany
        ORDER BY o.start_date ASC 
        ', $rsm);
        $sql->setParameters((array(
            'applicant' => $applicant->getId(),
            'searchTitle' => '%' . $searchTitle . '%',
            'searchCompany' => '%' . $searchCompany . '%',
            )));
        return $sql->getArrayResult();
    }

    public function findMatchingOffersForApplicantOrderByCreationDate(
        Applicant $applicant,
        string $searchTitle,
        string $searchCompany
    ): array {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('offer_id', 'offer_id');

        $sql = $this->getEntityManager()->createNativeQuery('
        SELECT COUNT(distinct hs.id) as `match_hs`, COUNT(distinct ss.id) as `match_ss`, 
            o.id as `offer_id`, o.title, o.contract_type, o.creation_date,
             o.start_date, o.city, o.id, o.company_id, c.name
        FROM applicant a
            JOIN applicant_hard_skills ahs on a.id = ahs.applicant_id
            JOIN offer_hard_skills ohs on ahs.skill_id = ohs.skill_id
            JOIN skill hs on ahs.skill_id = hs.id
            JOIN applicant_soft_skills ass on a.id = ass.applicant_id
            JOIN offer_soft_skills oss on ass.skill_id = oss.skill_id
            JOIN skill ss on ass.skill_id = ss.id
            JOIN offer o on ohs.offer_id = o.id and oss.offer_id = o.id
            JOIN company c on c.id = o.company_id
        WHERE a.id = :applicant
        GROUP BY o.id
        HAVING `match_hs` >= 5 and `match_ss` >= 5 and o.title like :searchTitle and c.name like :searchCompany
        ORDER BY o.creation_date ASC 
        ', $rsm);
        $sql->setParameters((array(
            'applicant' => $applicant->getId(),
            'searchTitle' => '%' . $searchTitle . '%',
            'searchCompany' => '%' . $searchCompany . '%',
            )));
        return $sql->getArrayResult();
    }

    public function findMatchingOffersForApplicantOrderByEndDate(
        Applicant $applicant,
        string $searchTitle,
        string $searchCompany
    ): array {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('offer_id', 'offer_id');

        $sql = $this->getEntityManager()->createNativeQuery('
        SELECT COUNT(distinct hs.id) as `match_hs`, COUNT(distinct ss.id) as `match_ss`, 
            o.id as `offer_id`, o.title, o.contract_type, o.creation_date,
             o.start_date, o.city, o.id, o.company_id, c.name
        FROM applicant a
            JOIN applicant_hard_skills ahs on a.id = ahs.applicant_id
            JOIN offer_hard_skills ohs on ahs.skill_id = ohs.skill_id
            JOIN skill hs on ahs.skill_id = hs.id
            JOIN applicant_soft_skills ass on a.id = ass.applicant_id
            JOIN offer_soft_skills oss on ass.skill_id = oss.skill_id
            JOIN skill ss on ass.skill_id = ss.id
            JOIN offer o on ohs.offer_id = o.id and oss.offer_id = o.id
            JOIN company c on c.id = o.company_id
        WHERE a.id = :applicant
        GROUP BY o.id
        HAVING `match_hs` >= 5 and `match_ss` >= 5 and o.title like :searchTitle and c.name like :searchCompany
        ORDER BY o.end_date ASC 
        ', $rsm);
        $sql->setParameters((array(
            'applicant' => $applicant->getId(),
            'searchTitle' => '%' . $searchTitle . '%',
            'searchCompany' => '%' . $searchCompany . '%',
            )));
        return $sql->getArrayResult();
    }

    public function findMatchingOffersForApplicantOrderByTitle(
        Applicant $applicant,
        string $searchTitle,
        string $searchCompany
    ): array {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('offer_id', 'offer_id');

        $sql = $this->getEntityManager()->createNativeQuery('
        SELECT COUNT(distinct hs.id) as `match_hs`, COUNT(distinct ss.id) as `match_ss`, 
            o.id as `offer_id`, o.title, o.contract_type, o.creation_date,
             o.start_date, o.city, o.id, o.company_id, c.name
        FROM applicant a
            JOIN applicant_hard_skills ahs on a.id = ahs.applicant_id
            JOIN offer_hard_skills ohs on ahs.skill_id = ohs.skill_id
            JOIN skill hs on ahs.skill_id = hs.id
            JOIN applicant_soft_skills ass on a.id = ass.applicant_id
            JOIN offer_soft_skills oss on ass.skill_id = oss.skill_id
            JOIN skill ss on ass.skill_id = ss.id
            JOIN offer o on ohs.offer_id = o.id and oss.offer_id = o.id
            JOIN company c on c.id = o.company_id
        WHERE a.id = :applicant
        GROUP BY o.id
        HAVING `match_hs` >= 5 and `match_ss` >= 5 and o.title like :searchTitle and c.name like :searchCompany
        ORDER BY o.title ASC 
        ', $rsm);
        $sql->setParameters((array(
            'applicant' => $applicant->getId(),
            'searchTitle' => '%' . $searchTitle . '%',
            'searchCompany' => '%' . $searchCompany . '%',
        )));
        return $sql->getArrayResult();
    }


    public function findMatchingOffersForApplicantOrderByCompany(
        Applicant $applicant,
        string $searchTitle,
        string $searchCompany
    ): array {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('offer_id', 'offer_id');

        $sql = $this->getEntityManager()->createNativeQuery('
        SELECT COUNT(distinct hs.id) as `match_hs`, COUNT(distinct ss.id) as `match_ss`, 
            o.id as `offer_id`, o.title, o.contract_type, o.creation_date,
             o.start_date, o.city, o.id, o.company_id, c.name
        FROM applicant a
            JOIN applicant_hard_skills ahs on a.id = ahs.applicant_id
            JOIN offer_hard_skills ohs on ahs.skill_id = ohs.skill_id
            JOIN skill hs on ahs.skill_id = hs.id
            JOIN applicant_soft_skills ass on a.id = ass.applicant_id
            JOIN offer_soft_skills oss on ass.skill_id = oss.skill_id
            JOIN skill ss on ass.skill_id = ss.id
            JOIN offer o on ohs.offer_id = o.id and oss.offer_id = o.id
            JOIN company c on c.id = o.company_id
        WHERE a.id = :applicant
        GROUP BY o.id
        HAVING `match_hs` >= 5 and `match_ss` >= 5 and o.title like :searchTitle and c.name like :searchCompany
        ORDER BY c.name ASC 
        ', $rsm);
        $sql->setParameters((array(
            'applicant' => $applicant->getId(),
            'searchTitle' => '%' . $searchTitle . '%',
            'searchCompany' => '%' . $searchCompany . '%',
            )));
        return $sql->getArrayResult();
    }

    public function countApplicant(): array
    {
        $queryBuilder =  $this->createQueryBuilder('a');
        $queryBuilder->select('COUNT(a.id) as value');
        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
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
