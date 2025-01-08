<?php

namespace App\Message\Chat;

class SendChatMessage
{
    public function __construct(
        private int $senderId,
        private int $recipientId,
        private string $content,
        private int $publicationId
    ) {}

    public function getSenderId(): int
    {
        return $this->senderId;
    }
    
    public function getRecipientId(): int
    {
        return $this->recipientId;
    }
    
    public function getContent(): string
    {
        return $this->content;
    }
    
    public function getPublicationId(): int
    {
        return $this->publicationId;
    }
}