<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    /**
     * @return Message[]
     */
    public function findByConversation(int $conversationId): array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.conversation = :val')
            ->setParameter('val', $conversationId)
            ->orderBy('m.createdAt', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function markAsRead(int $conversationId, int $userId)
    {
        return $this->createQueryBuilder('m')
            ->update()
            ->set('m.isRead', ':isRead')
            ->where('m.conversation = :conversationId')
            ->andWhere('m.sender != :userId')
            ->setParameter('isRead', true)
            ->setParameter('conversationId', $conversationId)
            ->setParameter('userId', $userId)
            ->getQuery()
            ->execute();
    }
}