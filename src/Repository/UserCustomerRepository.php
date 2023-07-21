<?php

namespace App\Repository;

use App\Entity\UserCustomer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserCustomer>
 *
 * @method UserCustomer|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserCustomer|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserCustomer[]    findAll()
 * @method UserCustomer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserCustomerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserCustomer::class);
    }

//    /**
//     * @return UserCustomer[] Returns an array of UserCustomer objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UserCustomer
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
