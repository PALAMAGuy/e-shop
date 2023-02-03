<?php

namespace App\Entity;

use App\Repository\PanierProduitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanierProduitRepository::class)]
class PanierProduit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'panierProduits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Produit $article = null;

    #[ORM\ManyToOne(inversedBy: 'panierProduits')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Panier $panier = null;

    #[ORM\Column]
    private ?int $quantity = null;

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

    public function getPanier(): ?Panier
    {
        return $this->panier;
    }

    public function setPanier(?Panier $panier): self
    {
        $this->panier = $panier;

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
}
