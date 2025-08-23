<?php

namespace App\Repository;

use App\Entity\Sweatshirt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sweatshirt>
 */
class SweatshirtRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sweatshirt::class);
    }


    public function findTop(): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.top = :top')
            ->setParameter('top', true)
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
        ;
    }

    public function sortByPriceRange(int $min, int $max): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.price >= :min')
            ->andWhere('s.price <= :max')
            ->setParameter('min', $min)
            ->setParameter('max', $max)
            ->getQuery()
            ->getResult()
        ;
    }
    
//    /**
//     * @return Sweatshirt[] Returns an array of Sweatshirt objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Sweatshirt
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
