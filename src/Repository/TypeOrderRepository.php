<?php

namespace App\Repository;

use App\Entity\TypeOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeOrder>
 *
 * @method TypeOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeOrder[]    findAll()
 * @method TypeOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeOrder::class);
    }

//    /**
//     * @return TypeOrder[] Returns an array of TypeOrder objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TypeOrder
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
