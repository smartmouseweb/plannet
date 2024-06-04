<?php

namespace App\Entity;

class ApiResponse
{
    private ?string $status = null;
    private ?string $statusMessage = null;
    private int $statusCode;
    private $payload;

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getStatusMessage(): ?string
    {
        return $this->statusMessage;
    }

    public function setStatusMessage(string $statusMessage): static
    {
        $this->statusMessage = $statusMessage;

        return $this;
    }

    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    public function setStatusCode(int $statusCode): static
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function getPayload(): ?array
    {
        return $this->payload;
    }

    public function setPayload(?array $payload): static
    {
        $this->payload = $payload;

        return $this;
    }

    public function output(): array
    {
        return ['status' => $this->status,
                'statusMessage' => $this->statusMessage,
                'statusCode' => $this->statusCode,
                'payload' => json_encode($this->payload),];
    }

    public function setResponse(string $status, int $statusCode, ?string $statusMessage, ?array $payload = []): bool
    {
        $this->setStatus($status);
        $this->setStatusCode($statusCode);
        $this->setStatusMessage($statusMessage);
        $this->setPayload($payload);

        return true;
    }

    public function setUserNotFoundResponse(): bool
    {
        $this->setStatus('Error');
        $this->setStatusCode('100');
        $this->setStatusMessage('User not found');
        
        return true;
    }
}
