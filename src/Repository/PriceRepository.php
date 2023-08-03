<?php

namespace App\Repository;

use App\Entity\GasStation;
use App\Entity\Price;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<Price>
 *
 * @method Price|null find($id, $lockMode = null, $lockVersion = null)
 * @method Price|null findOneBy(array $criteria, array $orderBy = null)
 * @method Price[]    findAll()
 * @method Price[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PriceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Price::class);
    }

    public function save(Price $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Price $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getPriceGreaterThan(int $limit, ?UserInterface $user)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('p')
            ->from('App:Price', 'p')
            ->where('p.createdAt > :createdAt')
            ->setParameter('createdAt', new Datetime(date('Y-m-d', strtotime('-' . $limit . ' days'))));
        if ($user && $user->getGasStation()) {
            $qb->andWhere('p.gasStation = :gas_station')
                ->setParameter('gas_station', $user->getGasStation());
        }
        $qb->addOrderBy('p.id', 'DESC');
        return $qb->getQuery()->getResult();
    }

    /**
     * @throws Exception
     */
    public function getPricesCount(?GasStation $gasStation): int
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('p')
            ->from('App:Price', 'p')
            ->where('p.createdAt >= :createdAt')
            ->andWhere('p.gasStation = :gas_station')
            ->setParameter('createdAt', new Datetime(date('Y-m-d')))
            ->setParameter('gas_station', $gasStation)
        ;
        return count($qb->getQuery()->getResult());
    }
}
