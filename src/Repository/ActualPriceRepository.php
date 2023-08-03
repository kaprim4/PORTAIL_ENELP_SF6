<?php

namespace App\Repository;

use App\Entity\ActualPrice;
use App\Entity\GasStation;
use App\Entity\Grade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ActualPrice>
 *
 * @method ActualPrice|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActualPrice|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActualPrice[]    findAll()
 * @method ActualPrice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActualPriceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActualPrice::class);
    }

    public function save(ActualPrice $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ActualPrice $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ActualPrice[] Returns an array of ActualPrice objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    public function getActualPricesByGrade(GasStation $gasStation, Grade $grade): ?ActualPrice
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.gasStation = :gasStation')
            ->andWhere('a.grade = :grade')
            ->setParameter('gasStation', $gasStation)
            ->setParameter('grade', $grade)
            ->orderBy('a.appliedAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
