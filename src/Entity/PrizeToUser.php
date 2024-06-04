<?php

namespace App\Entity;

use App\Repository\PrizeToUserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrizeToUserRepository::class)]
class PrizeToUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'prizeToUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'prizeToUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Prize $prize = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateAdded = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getPrize(): ?Prize
    {
        return $this->prize;
    }

    public function setPrize(?Prize $prize): static
    {
        $this->prize = $prize;

        return $this;
    }

    public function getDateAdded(): ?\DateTimeInterface
    {
        return $this->dateAdded;
    }

    public function setDateAdded(\DateTimeInterface $dateAdded): static
    {
        $this->dateAdded = $dateAdded;

        return $this;
    }

    public function packForApi(array $translationTypes, TranslationLocale $translationLocale, EntityManager $em): array
    {
        return [  
            'user' => [
                'id' => $this->getUser()->getId(),
                'name' => $this->getUser()->getEmail(),
            ],
            'prize' => [
                'id' => $this->getPrize()->getId(),
                'code' => $this->getPrize()->getCode(),
                'name' => $this->getPrize()->getName($translationTypes['Prize'], $translationLocale, $em),
                'description' => $this->getPrize()->getDescription($translationTypes['Prize'], $translationLocale, $em),
                'partner' => [
                    'id' => $this->getPrize()->getPartner()->getId(),
                    'code' => $this->getPrize()->getPartner()->getCode(),
                    'url' => $this->getPrize()->getPartner()->getUrl(),
                    'name' => $this->getPrize()->getPartner()->getName($translationTypes['Partner'], $translationLocale, $em),
                ]
            ],
        ];
    }
}
