<?php

namespace App\Repository;

use App\Entity\Etappe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Etappe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Etappe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Etappe[]    findAll()
 * @method Etappe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtappeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Etappe::class);
    }

    public function findByYear ($year)
    {
        $min = new \DateTime("@". strtotime($year - 1 . "-12-31"));
        $max = new \DateTime("@" . strtotime($year + 1 . "-1-1"));

        return $this->createQueryBuilder('e')
            ->andWhere("e.Date BETWEEN :min AND :max")
            ->setParameter('min', $min->format("Y-m-d"))
            ->setParameter('max', $max->format("Y-m-d"))
            ->orderBy('e.Date', "ASC")
            ->getQuery()
            ->getResult()
        ;
    }

    public function getYears ()
    {
        return $this->createQueryBuilder('e')
            ->select('YEAR(e.Date)')
            ->orderBy('e.Date', "DESC")
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Etappe[] Returns an array of Etappe objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Etappe
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
