<?php

namespace App\Repository;

use App\Entity\Conversation;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\ArrayCollection;

class ConversationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conversation::class);
    }

    public function findByUser(User $user): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.sender = :user OR c.recipient = :user')
            ->setParameter('user', $user)
            ->orderBy('c.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findByPublication(int $publicationId): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.publication = :publicationId')
            ->setParameter('publicationId', $publicationId)
            ->orderBy('c.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findExistingConversation(int $senderId, int $recipientId, int $publicationId): ?Conversation
    {
        return $this->createQueryBuilder('c')
            ->where('(c.sender = :senderId AND c.recipient = :recipientId) OR (c.sender = :recipientId AND c.recipient = :senderId)')
            ->andWhere('c.publication = :publicationId')
            ->setParameters(new ArrayCollection([
                'senderId' => $senderId,
                'recipientId' => $recipientId,
                'publicationId' => $publicationId
            ]))
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getUnreadCount(User $user): int
    {
        return $this->createQueryBuilder('c')
            ->select('COUNT(m.id)')
            ->leftJoin('c.messages', 'm')
            ->where('c.recipient = :user')
            ->andWhere('m.isRead = :isRead')
            ->andWhere('m.sender != :user')
            ->setParameters(new ArrayCollection([
                'user' => $user,
                'isRead' => false
            ]))
            ->getQuery()
            ->getSingleScalarResult();
    }
}