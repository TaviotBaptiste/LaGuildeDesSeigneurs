<?php

namespace App\Repository;

use App\Entity\Characterr;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Characterr|null find($id, $lockMode = null, $lockVersion = null)
 * @method Characterr|null findOneBy(array $criteria, array $orderBy = null)
 * @method Characterr[]    findAll()
 * @method Characterr[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharacterrRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Characterr::class);
    }

    // /**
    //  * @return Characterr[] Returns an array of Characterr objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Characterr
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
