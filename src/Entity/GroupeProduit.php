<?php

namespace App\Entity;

use App\Repository\GroupeProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupeProduitRepository::class)]
class GroupeProduit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'groupe', targetEntity: TypeProduit::class)]
    private Collection $typeProduits;

    public function __construct()
    {
        $this->typeProduits = new ArrayCollection();
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

    /**
     * @return Collection<int, TypeProduit>
     */
    public function getTypeProduits(): Collection
    {
        return $this->typeProduits;
    }

    public function addTypeProduit(TypeProduit $typeProduit): self
    {
        if (!$this->typeProduits->contains($typeProduit)) {
            $this->typeProduits->add($typeProduit);
            $typeProduit->setGroupe($this);
        }

        return $this;
    }

    public function removeTypeProduit(TypeProduit $typeProduit): self
    {
        if ($this->typeProduits->removeElement($typeProduit)) {
            // set the owning side to null (unless already changed)
            if ($typeProduit->getGroupe() === $this) {
                $typeProduit->setGroupe(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
