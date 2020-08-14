<?php

namespace App\Repository;

use App\Entity\Formulier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Formulier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Formulier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Formulier[]    findAll()
 * @method Formulier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormulierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Formulier::class);
    }

    // /**
    //  * @return Formulier[] Returns an array of Formulier objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Formulier
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
