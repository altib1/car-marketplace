<?php

namespace App\Message\Chat;

final class SendChatMessage
{
    public function __construct(
        private readonly int $senderId,
        private readonly int $recipientId,
        private readonly string $content,
        private readonly int $publicationId
    ) {}

    public function __serialize(): array
    {
        return [
            'senderId' => $this->senderId,
            'recipientId' => $this->recipientId,
            'content' => $this->content,
            'publicationId' => $this->publicationId,
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->senderId = $data['senderId'];
        $this->recipientId = $data['recipientId'];
        $this->content = $data['content'];
        $this->publicationId = $data['publicationId'];
    }

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