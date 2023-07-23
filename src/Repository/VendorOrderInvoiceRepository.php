<?php

namespace App\Repository;

use App\Entity\VendorOrderInvoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VendorOrderInvoice>
 *
 * @method VendorOrderInvoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method VendorOrderInvoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method VendorOrderInvoice[]    findAll()
 * @method VendorOrderInvoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VendorOrderInvoiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VendorOrderInvoice::class);
    }

//    /**
//     * @return VendorOrderInvoice[] Returns an array of VendorOrderInvoice objects
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

//    public function findOneBySomeField($value): ?VendorOrderInvoice
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
