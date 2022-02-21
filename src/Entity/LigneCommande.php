<?php

namespace App\Entity;

use App\Repository\LigneCommandeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LigneCommandeRepository::class)]
class LigneCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'ligneCommandes')]
    #[ORM\JoinColumn(nullable: false)]
    private $commande;

    #[ORM\Column(type: 'string', length: 255)]
    private $articleNom;

    #[ORM\Column(type: 'integer')]
    private $articleQuantite;

    #[ORM\Column(type: 'float')]
    private $articlePrix;

    #[ORM\Column(type: 'float')]
    private $total;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    public function getArticleNom(): ?string
    {
        return $this->articleNom;
    }

    public function setArticleNom(string $articleNom): self
    {
        $this->articleNom = $articleNom;

        return $this;
    }

    public function getArticleQuantite(): ?int
    {
        return $this->articleQuantite;
    }

    public function setArticleQuantite(int $articleQuantite): self
    {
        $this->articleQuantite = $articleQuantite;

        return $this;
    }

    public function getArticlePrix(): ?float
    {
        return $this->articlePrix;
    }

    public function setArticlePrix(float $articlePrix): self
    {
        $this->articlePrix = $articlePrix;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }
}
