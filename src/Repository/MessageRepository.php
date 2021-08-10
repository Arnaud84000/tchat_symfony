<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
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

    // /**
    //  * @return Message[] Returns an array of Message objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Message
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    // Recherche s'il y a déjà des messages échangés entre l'utilisateur connecté et l'utilisateur passé en paramètre d'url
    public function findMessagesByUsers(?int $otherUserId, $myId)
    {
        $qb = $this->createQueryBuilder('m')
            ->where('m.receiver=:me',
                'm.sender=:otherUser'
            )
            ->orWhere('m.receiver=:otherUser',
                'm.sender=:me'
            )
            ->orderBy('m.created_at','asc')
            ->setParameters([
                'me' => $myId,
                'otherUser' => $otherUserId
            ]);
        dd($qb->getQuery()->getResult());

       /* $qb = $this->createQueryBuilder('m');
        $qb
            ->select($qb->expr()->count('m.content'))
            ->where(
                $qb->expr()->eq('m.receiver',':me'),
                $qb->expr()->eq('m.sender',':otherUser')
            )->orWhere(
                $qb->expr()->eq('m.receiver',':otherUser'),
                $qb->expr()->eq('m.sender',':me')
            )->groupBy('m.sender')
            ->setParameters([
                'me' => $myId,
                'otherUser' => $otherUserId
            ]);
        dd($qb->getQuery()->getResult());
        return $qb->getQuery()->getResult();*/
    }
    public function getMessagesGroupBySender(?int $myId){

        $qb = $this->createQueryBuilder('m')
            ->where('m.receiver=:me')
            ->orWhere('m.sender=:me')
            ->addSelect('u.id')
            ->leftJoin('m.sender','u.id')
            ->orderBy('m.created_at','asc')
            ->setParameters([
                'me' => $myId
            ]);
        dd($qb->getQuery()->getResult());


        /*$qb = $this->createQueryBuilder('m')
            ->where('m.receiver=:me')
            ->orWhere('m.sender=:me')
            ->orderBy('m.created_at','asc')
            ->setParameters([
                'me' => $myId
            ]);
        return $qb->getQuery()->getResult();*/
    }
    public function getMessages(?int $myId){



        $qb = $this->createQueryBuilder('m')
            ->where('m.receiver=:me')
            ->orWhere('m.sender=:me')
            ->orderBy('m.created_at','asc')
            ->setParameters([
                'me' => $myId
            ]);
        return $qb->getQuery()->getResult();
        /*$qb = $this->createQueryBuilder('m')
            ->where('m.receiver=:me')
            ->orWhere('m.sender=:me')
            ->orderBy('m.created_at','asc')
            ->setParameters([
                'me' => $myId
            ]);
        return $qb->getQuery()->getResult();*/
    }
}
