<?php

namespace App\Repository;

use App\Entity\Sweatshirt;
use App\Entity\SweatshirtSize;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SweatshirtSize>
 */
class SweatshirtSizeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SweatshirtSize::class);
    }

    public function findAvailablesSizesForSweatshirt(Sweatshirt $sweatshirt) : array
    {
        return $this->createQueryBuilder('ss')
            ->Where('ss.sweatshirt =:sweatshirt')
            ->andWhere('ss.stock > 0')
            ->setParameter('sweatshirt', $sweatshirt)
            ->getQuery()
            ->getResult()
        ;
    }

//    /**
//     * @return SweatshirtSize[] Returns an array of SweatshirtSize objects
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

//    public function findOneBySomeField($value): ?SweatshirtSize
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
