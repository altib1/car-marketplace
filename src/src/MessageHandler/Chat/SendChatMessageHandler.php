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
        private EntityManagerInterface $entityManager,
        private ConversationRepository $conversationRepository,
        private PublicationRepository $publicationRepository,
        private UserRepository $userRepository
    ) {}

    public function __invoke(SendChatMessage $message): void
    {
        $sender = $this->userRepository->find($message->getSenderId());
        $recipient = $this->userRepository->find($message->getRecipientId());
        $publication = $this->publicationRepository->find($message->getPublicationId());

        if (!$sender || !$recipient || !$publication) {
            throw new \InvalidArgumentException('One or more entities not found');
        }

        $conversation = $this->getOrCreateConversation($sender, $recipient, $publication);
        $this->createAndSaveMessage($message->getContent(), $sender, $conversation);
    }

    private function getOrCreateConversation(User $sender, User $recipient, Publication $publication): Conversation
    {
        $conversation = $this->conversationRepository->findExistingConversation(
            $sender->getId(),
            $recipient->getId(),
            $publication->getId()
        );

        if (!$conversation) {
            $conversation = new Conversation();
            $conversation->setSender($sender)
                        ->setRecipient($recipient)
                        ->setPublication($publication);
            $this->entityManager->persist($conversation);
        }

        return $conversation;
    }

    private function createAndSaveMessage(string $content, User $sender, Conversation $conversation): void
    {
        $chatMessage = new Message();
        $chatMessage->setContent($content)
                   ->setSender($sender)
                   ->setConversation($conversation);
        
        $this->entityManager->persist($chatMessage);
        $this->entityManager->flush();
    }
}
