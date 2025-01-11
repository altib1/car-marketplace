<?php

namespace App\Message\Chat;

class SendChatMessage implements \Serializable
{
    private int $senderId;
    private int $recipientId;
    private string $content;
    private int $publicationId;

    public function __construct(
        int $senderId,
        int $recipientId,
        string $content,
        int $publicationId
    ) {
        $this->senderId = $senderId;
        $this->recipientId = $recipientId;
        $this->content = $content;
        $this->publicationId = $publicationId;
    }

    public function serialize(): string
    {
        return serialize([
            'senderId' => $this->senderId,
            'recipientId' => $this->recipientId,
            'content' => $this->content,
            'publicationId' => $this->publicationId,
        ]);
    }

    public function unserialize(string $data): void
    {
        $data = unserialize($data);
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