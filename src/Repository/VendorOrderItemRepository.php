<?php

namespace App\Repository;

use App\Entity\VendorOrderItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VendorOrderItem>
 *
 * @method VendorOrderItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method VendorOrderItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method VendorOrderItem[]    findAll()
 * @method VendorOrderItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VendorOrderItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VendorOrderItem::class);
    }

//    /**
//     * @return VendorOrderItem[] Returns an array of VendorOrderItem objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?VendorOrderItem
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
