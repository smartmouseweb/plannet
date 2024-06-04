<?php

namespace App\Entity;

use App\Repository\PrizeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrizeRepository::class)]
class Prize
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'prizes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Partner $partner = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    /**
     * @var Collection<int, PrizeToUser>
     */
    #[ORM\OneToMany(targetEntity: PrizeToUser::class, mappedBy: 'prize')]
    private Collection $prizeToUsers;

    public function __construct()
    {
        $this->prizeToUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPartner(): ?Partner
    {
        return $this->partner;
    }

    public function setPartner(?Partner $partner): static
    {
        $this->partner = $partner;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection<int, PrizeToUser>
     */
    public function getPrizeToUsers(): Collection
    {
        return $this->prizeToUsers;
    }

    public function addPrizeToUser(PrizeToUser $prizeToUser): static
    {
        if (!$this->prizeToUsers->contains($prizeToUser)) {
            $this->prizeToUsers->add($prizeToUser);
            $prizeToUser->setPrize($this);
        }

        return $this;
    }

    public function removePrizeToUser(PrizeToUser $prizeToUser): static
    {
        if ($this->prizeToUsers->removeElement($prizeToUser)) {
            // set the owning side to null (unless already changed)
            if ($prizeToUser->getPrize() === $this) {
                $prizeToUser->setPrize(null);
            }
        }

        return $this;
    }

    public function getName(TranslationType $translationType, TranslationLocale $translationLocale, EntityManagerInterface $em)
    {
        $row = $em->getRepository(Translation::class)->findField([  'type' => $translationType, 
                                                                    'locale' => $translationLocale, 
                                                                    'bindId' => $this->getId(), 
                                                                    'field' => 'name']);
        return $row->getValue();
    }

    public function getDescription(TranslationType $translationType, TranslationLocale $translationLocale, EntityManagerInterface $em)
    {
        $row = $em->getRepository(Translation::class)->findField([  'type' => $translationType, 
                                                                    'locale' => $translationLocale, 
                                                                    'bindId' => $this->getId(), 
                                                                    'field' => 'description']);
        return $row->getValue();
    }

}
