<?php

namespace App\Repository;

use App\Entity\CarouselHeader;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CarouselHeader|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarouselHeader|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarouselHeader[]    findAll()
 * @method CarouselHeader[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarouselHeaderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarouselHeader::class);
    }

    // /**
    //  * @return CarouselHeader[] Returns an array of CarouselHeader objects
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
    public function findOneBySomeField($value): ?CarouselHeader
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
