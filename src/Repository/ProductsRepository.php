<?php

namespace App\Repository;

use App\Entity\Products;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Products>
 *
 * @method Products|null find($id, $lockMode = null, $lockVersion = null)
 * @method Products|null findOneBy(array $criteria, array $orderBy = null)
 * @method Products[]    findAll()
 * @method Products[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Products::class);
    }

    public function save(Products $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Products $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Products[] Returns an array of Products objects
//
   public function orderByValueASC($id): array
    {
        $orderbyProduct = $this->createQueryBuilder('p')

           ->orderBy('p.price', 'ASC')
            ->setParameter('id', $id)
            ->andWhere('p.categories = :id');



        return $orderbyProduct->getQuery()->getResult();


   }

    public function orderByValueDESC($id): array
    {
        $orderbyProduct = $this->createQueryBuilder('p')

            ->orderBy('p.price', 'DESC')
            ->setParameter('id', $id)
            ->andWhere('p.categories = :id');



        return $orderbyProduct->getQuery()->getResult();


    }

//    public function findOneBySomeField($value): ?Products
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
