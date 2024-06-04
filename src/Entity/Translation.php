<?php

namespace App\Entity;

use App\Repository\TranslationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TranslationRepository::class)]
class Translation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private ?int $bindId;

    #[ORM\ManyToOne(inversedBy: 'translations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TranslationType $type = null;

    #[ORM\ManyToOne(inversedBy: 'translations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TranslationLocale $locale = null;

    #[ORM\Column(length: 255)]
    private ?string $field = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $value = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?TranslationType
    {
        return $this->type;
    }

    public function setType(?TranslationType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getLocale(): ?TranslationLocale
    {
        return $this->locale;
    }

    public function setLocale(?TranslationLocale $locale): static
    {
        $this->locale = $locale;

        return $this;
    }

    public function getField(): ?string
    {
        return $this->field;
    }

    public function setField(string $field): static
    {
        $this->field = $field;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getBindId(): ?int
    {
        return $this->bindId;
    }

    public function setBindId(int $bindId): static
    {
        $this->bindId = $bindId;

        return $this;
    }

}
