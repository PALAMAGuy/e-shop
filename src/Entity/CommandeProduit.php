<?php

namespace App\Entity;

use App\Repository\CommandeProduitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeProduitRepository::class)]
class CommandeProduit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'commandeProduits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Produit $article = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'commandeProduits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Commande $commande = null;

    #[ORM\Column]
    private ?float $frais_port = null;

    #[ORM\Column]
    private ?bool $assurance = null;

    #[ORM\Column]
    private ?float $tva = null;

    #[ORM\Column]
    private ?float $prix = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticle(): ?Produit
    {
        return $this->article;
    }

    public function setArticle(?Produit $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
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

    public function getFraisPort(): ?float
    {
        return $this->frais_port;
    }

    public function setFraisPort(float $frais_port): self
    {
        $this->frais_port = $frais_port;

        return $this;
    }

    public function isAssurance(): ?bool
    {
        return $this->assurance;
    }

    public function setAssurance(bool $assurance): self
    {
        $this->assurance = $assurance;

        return $this;
    }

    public function getTva(): ?float
    {
        return $this->tva;
    }

    public function setTva(float $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
}
