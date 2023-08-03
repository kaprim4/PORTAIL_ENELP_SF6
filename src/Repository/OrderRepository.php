<?php

namespace App\Repository;

use App\Entity\GasStation;
use App\Entity\Order;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<Order>
 *
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function save(Order $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Order $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Order[] Returns an array of Order objects
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

//    public function findOneBySomeField($value): ?Order
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    /**
     * @throws Exception
     */
    public function getOrdersCount(?GasStation $gasStation): int
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('o')
            ->from('App:Order', 'o')
            ->where('o.createdAt >= :createdAt')
            ->andWhere('o.gasStation = :gas_station')
            ->setParameter('createdAt', new Datetime(date('Y-m-d')))
            ->setParameter('gas_station', $gasStation)
        ;
        return count($qb->getQuery()->getResult());
    }

    public function getOrdersByGasStation(?GasStation $gasStation)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('o')
            ->from('App:Order', 'o')
            ->where('o.gasStation = :gas_station')
            ->setParameter('gas_station', $gasStation)
            ->addOrderBy('o.id', 'DESC');
        return $qb->getQuery()->getResult();
    }

    /**
     * @throws Exception
     */
    public function getOrdersCountAddedPerDate(?GasStation $gasStation, string $desired_delivery_date): int
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('o')
            ->from('App:Order', 'o')
            ->where('o.createdAt >= :createdAt')
            ->andWhere('o.gasStation = :gas_station')
            ->setParameter('createdAt', new Datetime($desired_delivery_date))
            ->setParameter('gas_station', $gasStation)
        ;
        return count($qb->getQuery()->getResult());
    }
    public function getOrderGreaterThan(int $limit, ?UserInterface $user)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('o')
            ->from('App:Order', 'o')
            ->where('o.createdAt > :createdAt')
            ->setParameter('createdAt', new Datetime(date('Y-m-d', strtotime('-' . $limit . ' days'))));
        if ($user && $user->getGasStation()) {
            $qb->andWhere('o.gasStation = :gas_station')
                ->setParameter('gas_station', $user->getGasStation());
        }
        $qb->addOrderBy('o.id', 'DESC');
        return $qb->getQuery()->getResult();
    }

    public function getMaxOrderId()
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('o.sellDocWeb')
            ->from('App:Order', 'o')
            ->addOrderBy('o.id', 'DESC')
            ->setMaxResults(1)
        ;
        return $qb->getQuery()->getResult();
    }
}
