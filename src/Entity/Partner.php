<?php

namespace App\Entity;

use App\Repository\PartnerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartnerRepository::class)]
class Partner
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $url = null;

    #[ORM\Column(length: 255, unique: true )]
    private ?string $code = null;

    /**
     * @var Collection<int, Prize>
     */
    #[ORM\OneToMany(targetEntity: Prize::class, mappedBy: 'partner')]
    private Collection $prizes;

    public function __construct()
    {
        $this->prizes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

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
     * @return Collection<int, Prize>
     */
    public function getPrizes(): Collection
    {
        return $this->prizes;
    }

    public function addPrize(Prize $prize): static
    {
        if (!$this->prizes->contains($prize)) {
            $this->prizes->add($prize);
            $prize->setPartner($this);
        }

        return $this;
    }

    public function removePrize(Prize $prize): static
    {
        if ($this->prizes->removeElement($prize)) {
            // set the owning side to null (unless already changed)
            if ($prize->getPartner() === $this) {
                $prize->setPartner(null);
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
}
