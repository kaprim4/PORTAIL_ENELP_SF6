<?php

namespace App\Repository;

use App\Entity\Message;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<Message>
 *
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function save(Message $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Message $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @throws Exception
     */
    public function getMessageGreaterThan(int $limit, ?UserInterface $user)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('p')
            ->from('App:Message', 'p')
            ->where('p.createdAt > :createdAt')
            ->setParameter('createdAt', new Datetime(date('Y-m-d', strtotime('-' . $limit . ' days'))));
        if ($user) {
            $qb->andWhere('p.receiver = :receiver')
                ->setParameter('receiver', $user);
        }
        $qb->addOrderBy('p.id', 'DESC');
        return $qb->getQuery()->getResult();
    }

    /**
     * @throws Exception
     */
    public function getMessagesCount(?UserInterface $user): int
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('p')
            ->from('App:Message', 'p')
            ->where('p.createdAt >= :createdAt')
            ->andWhere('p.receiver = :receiver')
            ->setParameter('createdAt', new Datetime(date('Y-m-d')))
            ->setParameter('receiver', $user)
        ;
        return count($qb->getQuery()->getResult());
    }

    /*public function getMaxMessageId()
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('o.reference')
            ->from('App:Message', 'o')
            ->addOrderBy('o.id', 'DESC')
            ->setMaxResults(1)
        ;
        return $qb->getQuery()->getResult();
    }*/
}
