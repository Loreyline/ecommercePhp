<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $reference;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\Column(type: 'text')]
    private $adresseLivraison;

    #[ORM\Column(type: 'string', length: 255)]
    private $transporteur;

    #[ORM\Column(type: 'float')]
    private $transPrix;

    #[ORM\Column(type: 'text')]
    private $adresseFacturation;

    #[ORM\Column(type: 'boolean')]
    private $isFinalisee;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: LigneCommande::class)]
    private $ligneCommandes;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $stripeSessionId;

    public function __construct()
    {
        $this->ligneCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getAdresseLivraison(): ?string
    {
        return $this->adresseLivraison;
    }

    public function setAdresseLivraison(string $adresseLivraison): self
    {
        $this->adresseLivraison = $adresseLivraison;

        return $this;
    }

    public function getTransporteur(): ?string
    {
        return $this->transporteur;
    }

    public function setTransporteur(string $transporteur): self
    {
        $this->transporteur = $transporteur;

        return $this;
    }

    public function getTransPrix(): ?float
    {
        return $this->transPrix;
    }

    public function setTransPrix(float $transPrix): self
    {
        $this->transPrix = $transPrix;

        return $this;
    }

    public function getAdresseFacturation(): ?string
    {
        return $this->adresseFacturation;
    }

    public function setAdresseFacturation(string $adresseFacturation): self
    {
        $this->adresseFacturation = $adresseFacturation;

        return $this;
    }

    public function getIsFinalisee(): ?bool
    {
        return $this->isFinalisee;
    }

    public function setIsFinalisee(bool $isFinalisee): self
    {
        $this->isFinalisee = $isFinalisee;

        return $this;
    }

    /**
     * @return Collection|LigneCommande[]
     */
    public function getLigneCommandes(): Collection
    {
        return $this->ligneCommandes;
    }

    public function addLigneCommande(LigneCommande $ligneCommande): self
    {
        if (!$this->ligneCommandes->contains($ligneCommande)) {
            $this->ligneCommandes[] = $ligneCommande;
            $ligneCommande->setCommande($this);
        }

        return $this;
    }

    public function removeLigneCommande(LigneCommande $ligneCommande): self
    {
        if ($this->ligneCommandes->removeElement($ligneCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneCommande->getCommande() === $this) {
                $ligneCommande->setCommande(null);
            }
        }

        return $this;
    }

    public function getStripeSessionId(): ?string
    {
        return $this->stripeSessionId;
    }

    public function setStripeSessionId(?string $stripeSessionId): self
    {
        $this->stripeSessionId = $stripeSessionId;

        return $this;
    }
}
