<?php

namespace App\Repository;

use App\Entity\OrderInvoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderInvoice>
 *
 * @method OrderInvoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderInvoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderInvoice[]    findAll()
 * @method OrderInvoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderInvoiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderInvoice::class);
    }

//    /**
//     * @return OrderInvoice[] Returns an array of OrderInvoice objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?OrderInvoice
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
