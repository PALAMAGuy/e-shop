<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $img = null;

    #[ORM\Column]
    private ?int $nb_en_stock = null;

    #[ORM\Column]
    private ?int $note = null;

    #[ORM\ManyToMany(targetEntity: Marque::class, inversedBy: 'produits')]
    private Collection $marque;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategorieProduit $categorie = null;

    /** 
      * @Assert\NotBlank(message="Please, upload the photo.") 
      * @Assert\File(mimeTypes={ "image/png", "image/jpeg" }) 
    */ 
    private $photo;

    #[ORM\OneToMany(mappedBy: 'article', targetEntity: Stock::class)]
    private Collection $stocks;

    #[ORM\OneToMany(mappedBy: 'article', targetEntity: PanierProduit::class, orphanRemoval: true)]
    private Collection $panierProduits;

    #[ORM\OneToMany(mappedBy: 'article', targetEntity: CommandeProduit::class, orphanRemoval: true)]
    private Collection $commandeProduits;

    public function __construct()
    {
        $this->marque = new ArrayCollection();
        $this->stocks = new ArrayCollection();
        $this->panierProduits = new ArrayCollection();
        $this->commandeProduits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

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

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }
    public function getPhoto() { 
        return $this->photo; 
    } 

    public function setPhoto($photo) { 
        $this->photo = $photo; 
        return $this; 
    }

    public function __toString()
    {
        return $this->name;
    }
    /**
     * @return Collection<int, Marque>
     */
    public function getMarque(): Collection
    {
        return $this->marque;
    }

    public function addMarque(Marque $marque): self
    {
        if (!$this->marque->contains($marque)) {
            $this->marque->add($marque);
        }

        return $this;
    }

    public function removeMarque(Marque $marque): self
    {
        $this->marque->removeElement($marque);

        return $this;
    }

    public function getCategorie(): ?CategorieProduit
    {
        return $this->categorie;
    }

    public function setCategorie(?CategorieProduit $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection<int, Stock>
     */
    public function getStocks(): Collection
    {
        return $this->stocks;
    }

    public function addStock(Stock $stock): self
    {
        if (!$this->stocks->contains($stock)) {
            $this->stocks->add($stock);
            $stock->setArticle($this);
        }

        return $this;
    }

    public function removeStock(Stock $stock): self
    {
        if ($this->stocks->removeElement($stock)) {
            // set the owning side to null (unless already changed)
            if ($stock->getArticle() === $this) {
                $stock->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PanierProduit>
     */
    public function getPanierProduits(): Collection
    {
        return $this->panierProduits;
    }

    public function addPanierProduit(PanierProduit $panierProduit): self
    {
        if (!$this->panierProduits->contains($panierProduit)) {
            $this->panierProduits->add($panierProduit);
            $panierProduit->setArticle($this);
        }

        return $this;
    }

    public function removePanierProduit(PanierProduit $panierProduit): self
    {
        if ($this->panierProduits->removeElement($panierProduit)) {
            // set the owning side to null (unless already changed)
            if ($panierProduit->getArticle() === $this) {
                $panierProduit->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CommandeProduit>
     */
    public function getCommandeProduits(): Collection
    {
        return $this->commandeProduits;
    }

    public function addCommandeProduit(CommandeProduit $commandeProduit): self
    {
        if (!$this->commandeProduits->contains($commandeProduit)) {
            $this->commandeProduits->add($commandeProduit);
            $commandeProduit->setArticle($this);
        }

        return $this;
    }

    public function removeCommandeProduit(CommandeProduit $commandeProduit): self
    {
        if ($this->commandeProduits->removeElement($commandeProduit)) {
            // set the owning side to null (unless already changed)
            if ($commandeProduit->getArticle() === $this) {
                $commandeProduit->setArticle(null);
            }
        }

        return $this;
    }
}
