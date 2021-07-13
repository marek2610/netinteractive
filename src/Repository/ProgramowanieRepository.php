<?php

namespace App\Repository;

use App\Entity\Programowanie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Programowanie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Programowanie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Programowanie[]    findAll()
 * @method Programowanie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProgramowanieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Programowanie::class);
    }

    // /**
    //  * @return Programowanie[] Returns an array of Programowanie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Programowanie
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
