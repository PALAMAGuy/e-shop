<?php

namespace App\Entity;

use App\Repository\StockRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockRepository::class)]
class Stock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'stocks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Produit $article = null;

    #[ORM\ManyToOne(inversedBy: 'stocks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Stockage $stockage = null;

    #[ORM\Column]
    private ?int $nb_en_stock = null;

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

    public function getStockage(): ?Stockage
    {
        return $this->stockage;
    }

    public function setStockage(?Stockage $stockage): self
    {
        $this->stockage = $stockage;

        return $this;
    }

    public function getNbEnStock(): ?int
    {
        return $this->nb_en_stock;
    }

    public function setNbEnStock(int $nb_en_stock): self
    {
        $this->nb_en_stock = $nb_en_stock;

        return $this;
    }
    
}
