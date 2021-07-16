<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
    public function upgradePassword(UserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }


    public function findByLastThirty()
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.created_at BETWEEN :n30days And :today')
            ->setParameter('today', date('Y-m-d', strtotime("1 days")))
            ->setParameter('n30days', date('Y-m-d', strtotime("-30 days")))
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByLastSeven()
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.created_at BETWEEN :n7days And :today')
            ->setParameter('today', date('Y-m-d', strtotime("1 days")))
            ->setParameter('n7days', date('Y-m-d', strtotime("-7 days")))
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByLastThree()
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.created_at BETWEEN :n3days And :today')
            ->setParameter('today', date('Y-m-d', strtotime("1 days")))
            ->setParameter('n3days', date('Y-m-d', strtotime("-3 days")))
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByOfAge()
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.dob = :today')
            ->setParameter('today', date('Y-m-d', strtotime("+18 years")))
            // ->andWhere('u.dob < :dzis')
            // ->setParameter('dzis', new \DateTime())
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

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
