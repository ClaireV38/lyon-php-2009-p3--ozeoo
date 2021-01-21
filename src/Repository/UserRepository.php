<?php

namespace App\Repository;

use App\Entity\Company;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /*public function findNotVerifiedCompanies(User $user, Company $company): array
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('is_verified', 'is_verified');
        $rsm->addScalarResult('email', 'email');
        $rsm->addScalarResult('name', 'name');
        $rsm->addScalarResult('siret_nb', 'siret_nb');
        $rsm->addScalarResult('ape_nb', 'ape_nb');


        $sql = $this->getEntityManager()->createNativeQuery('
        SELECT is_verified, user.email, company.name, company.siret_nb, company.ape_nb
        FROM user
            JOIN company on company.user_id = user.id
        WHERE is_verified = 0
        ORDER BY user.id DESC 
        ', $rsm);
        $sql->setParameters((array('user' => $user->getId())));
        return $sql->getArrayResult();
    }*/

    /**
     * @return User[] Returns an array of User objects
     */
    public function findByExampleField()
    {
        return $this->createQueryBuilder('u')
            ->select('c')
            ->andWhere('u.isVerified = 0')
            ->join('user.company', 'c')
            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
