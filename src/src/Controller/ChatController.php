<?php

namespace App\Controller;

use App\Message\Chat\SendChatMessage;
use App\Repository\ConversationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MessageRepository;
use App\Entity\Conversation;
use App\Repository\UserRepository;
use App\Entity\User;

#[Route('/chat')]
class ChatController extends AbstractController
{
    #[Route('/', name: 'app_chat_inbox')]
    public function inbox(ConversationRepository $conversationRepository): Response
    {
        /** @var User */
        $user = $this->getUser();
        
        if (!$user) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('chat/inbox.html.twig', [
            'conversations' => $conversationRepository->findByUser($user)
        ]);
    }

    #[Route('/send', name: 'app_chat_send', methods: ['POST'])]
    public function send(
        Request $request, 
        MessageBusInterface $bus,
        UserRepository $userRepository
    ): Response
    {
        /** @var User */
        $user = $this->getUser();
        
        if (!$user) {
            throw $this->createAccessDeniedException('You must be logged in to send messages');
        }
    
        $recipientId = $request->request->get('recipientId');
        
        if (!$recipientId) {
            throw $this->createNotFoundException('Recipient is required');
        }
    
        if ($recipientId == $user->getId()) {
            throw $this->createAccessDeniedException('Cannot send message to yourself');
        }
    
        $recipient = $userRepository->find($recipientId);
        if (!$recipient) {
            throw $this->createNotFoundException('Recipient not found');
        }

        $content = $request->request->get('content');
        if (empty(trim($content))) {
            throw $this->createNotFoundException('Message content cannot be empty');
        }
    
        $message = new SendChatMessage(
            $user->getId(),
            $recipient->getId(),
            $content,
            (int) $request->request->get('publicationId')
        );
    
        $bus->dispatch($message);
    
        return $this->json(['status' => 'success']);
    }

    #[Route('/conversation/{id}', name: 'app_chat_conversation')]
    public function conversation(
        Conversation $conversation, 
        MessageRepository $messageRepository
    ): Response
    {
        // Security check
        if ($conversation->getSender() !== $this->getUser() && 
            $conversation->getRecipient() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('chat/conversation.html.twig', [
            'conversation' => $conversation,
            'messages' => $messageRepository->findByConversation($conversation->getId())
        ]);
    }

    #[Route('/conversation/{id}/delete', name: 'app_chat_conversation_delete', methods: ['POST'])]
    public function delete(
        Conversation $conversation,
        ConversationRepository $conversationRepository,
        MessageRepository $messageRepository
    ): Response
    {
        // Security check
        if ($conversation->getSender() !== $this->getUser() && 
            $conversation->getRecipient() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        // Delete all messages
        $messageRepository->deleteByConversation($conversation->getId());

        // Delete conversation
        $conversationRepository->remove($conversation, true);

        return $this->redirectToRoute('app_chat_inbox');
    }
}