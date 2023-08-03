<?php

namespace App\Repository;

use App\Entity\GasStation;
use App\Entity\Grade;
use App\Entity\WholesalePriceDetail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WholesalePriceDetail>
 *
 * @method WholesalePriceDetail|null find($id, $lockMode = null, $lockVersion = null)
 * @method WholesalePriceDetail|null findOneBy(array $criteria, array $orderBy = null)
 * @method WholesalePriceDetail[]    findAll()
 * @method WholesalePriceDetail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WholesalePriceDetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WholesalePriceDetail::class);
    }

    public function save(WholesalePriceDetail $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(WholesalePriceDetail $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getWholesalePricesByGrade(GasStation $gasStation, Grade $grade): ?WholesalePriceDetail
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.gasStation = :gasStation')
            ->andWhere('a.grade = :grade')
            ->setParameter('gasStation', $gasStation)
            ->setParameter('grade', $grade)
            ->orderBy('a.wholesalePrice', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

//    /**
//     * @return WholesalePriceDetail[] Returns an array of WholesalePriceDetail objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('w.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?WholesalePriceDetail
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
