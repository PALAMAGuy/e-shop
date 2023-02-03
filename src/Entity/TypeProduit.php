<?php

namespace App\Entity;

use App\Repository\TypeProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TypeProduitRepository::class)]
class TypeProduit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'typeProduits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?GroupeProduit $groupe = null;

    #[ORM\Column(length: 255)]
    private ?string $img = null;

    /** 
      * @Assert\NotBlank(message="Please, upload the photo.") 
      * @Assert\File(mimeTypes={ "image/png", "image/jpeg" }) 
    */ 
    private $photo;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: CategorieProduit::class, orphanRemoval: true)]
    private Collection $categorieProduits;

    public function __construct()
    {
        $this->categorieProduits = new ArrayCollection();
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

    public function getGroupe(): ?GroupeProduit
    {
        return $this->groupe;
    }

    public function setGroupe(?GroupeProduit $groupe): self
    {
        $this->groupe = $groupe;

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
     * @return Collection<int, CategorieProduit>
     */
    public function getCategorieProduits(): Collection
    {
        return $this->categorieProduits;
    }

    public function addCategorieProduit(CategorieProduit $categorieProduit): self
    {
        if (!$this->categorieProduits->contains($categorieProduit)) {
            $this->categorieProduits->add($categorieProduit);
            $categorieProduit->setType($this);
        }

        return $this;
    }

    public function removeCategorieProduit(CategorieProduit $categorieProduit): self
    {
        if ($this->categorieProduits->removeElement($categorieProduit)) {
            // set the owning side to null (unless already changed)
            if ($categorieProduit->getType() === $this) {
                $categorieProduit->setType(null);
            }
        }

        return $this;
    } 
}
