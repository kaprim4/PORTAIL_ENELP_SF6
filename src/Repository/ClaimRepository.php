<?php

namespace App\Repository;

use App\Entity\Claim;
use App\Entity\GasStation;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<Claim>
 *
 * @method Claim|null find($id, $lockMode = null, $lockVersion = null)
 * @method Claim|null findOneBy(array $criteria, array $orderBy = null)
 * @method Claim[]    findAll()
 * @method Claim[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClaimRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Claim::class);
    }

    public function save(Claim $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Claim $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @throws Exception
     */
    public function getClaimGreaterThan(int $limit, ?UserInterface $user)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('p')
            ->from('App:Claim', 'p')
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
    public function getClaimsCount(?GasStation $gasStation): int
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('p')
            ->from('App:Claim', 'p')
            ->where('p.gasStation = :gas_station')
            ->setParameter('gas_station', $gasStation)
        ;
        return count($qb->getQuery()->getResult());
    }

    public function getMaxClaimId()
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('o.reference')
            ->from('App:Claim', 'o')
            ->addOrderBy('o.id', 'DESC')
            ->setMaxResults(1)
        ;
        return $qb->getQuery()->getResult();
    }
}
