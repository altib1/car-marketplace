<?php

namespace App\MessageHandler\Chat;

use App\Message\Chat\SendChatMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Conversation;
use App\Entity\Message;
use App\Entity\User;
use App\Entity\Publication;
use App\Repository\ConversationRepository;
use App\Repository\PublicationRepository;

#[AsMessageHandler]
class SendChatMessageHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ConversationRepository $conversationRepository,
        private PublicationRepository $publicationRepository
    ) {}

    public function __invoke(SendChatMessage $message)
    {
        $sender = $this->entityManager->getReference('App\Entity\User', $message->getSenderId());
        $recipient = $this->entityManager->getReference('App\Entity\User', $message->getRecipientId());
        $publication = $this->publicationRepository->find($message->getPublicationId());

        if (!$publication) {
            throw new \InvalidArgumentException('Publication not found');
        }

        // Find existing conversation
        $conversation = $this->conversationRepository->findExistingConversation(
            $message->getSenderId(),
            $message->getRecipientId(),
            $message->getPublicationId()
        );

        if (!$conversation) {
            $conversation = new Conversation();
            $conversation->setSender($sender);
            $conversation->setRecipient($recipient);
            $conversation->setPublication($publication);
            $this->entityManager->persist($conversation);
        }

        $chatMessage = new Message();
        $chatMessage->setContent($message->getContent());
        $chatMessage->setSender($sender);
        $chatMessage->setConversation($conversation);
        
        $this->entityManager->persist($chatMessage);
        $this->entityManager->flush();
    }
}