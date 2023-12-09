<?php

namespace App\Repository;

use App\Entity\DetailOrders;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DetailOrders>
 *
 * @method DetailOrders|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetailOrders|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetailOrders[]    findAll()
 * @method DetailOrders[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailOrdersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetailOrders::class);
    }

//    /**
//     * @return DetailOrders[] Returns an array of DetailOrders objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DetailOrders
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
