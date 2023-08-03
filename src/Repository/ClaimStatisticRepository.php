<?php

namespace App\Repository;

use App\Entity\ClaimStatistic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ClaimStatistic>
 *
 * @method ClaimStatistic|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClaimStatistic|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClaimStatistic[]    findAll()
 * @method ClaimStatistic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClaimStatisticRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClaimStatistic::class);
    }

    public function save(ClaimStatistic $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ClaimStatistic $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
