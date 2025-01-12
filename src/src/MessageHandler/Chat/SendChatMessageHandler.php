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
use Symfony\Component\Validator\Exception\ValidatorException;
use App\Repository\UserRepository;

#[AsMessageHandler]
class SendChatMessageHandler
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserRepository $userRepository,
        private readonly PublicationRepository $publicationRepository,
        private readonly ConversationRepository $conversationRepository
    ) {}

    public function __invoke(SendChatMessage $message): void
    {
        // Load full entities
        $sender = $this->userRepository->find($message->getSenderId());
        $recipient = $this->userRepository->find($message->getRecipientId());
        $publication = $this->publicationRepository->find($message->getPublicationId());

        if (!$sender || !$recipient || !$publication) {
            throw new \InvalidArgumentException('Required entity not found');
        }

        if (empty($message->getContent())) {
            throw new ValidatorException('Message content cannot be empty');
        }

        // Find or create conversation using full entities
        $conversation = $this->conversationRepository->findExistingConversation(
            $sender->getId(),
            $recipient->getId(),
            $publication->getId()
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
