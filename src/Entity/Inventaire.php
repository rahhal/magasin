<?php

namespace App\Entity;

use App\Repository\InventaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InventaireRepository::class)
 */
class Inventaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $num_inv;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity=LigneInventaire::class, mappedBy="inventaire", cascade={"persist"}, orphanRemoval=true)
     */
    private $ligneInventaires;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="inventaires")
     */
    private $user;

    public function __construct()
    {
        $this->ligneInventaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumInv(): ?string
    {
        return $this->num_inv;
    }

    public function setNumInv(string $num_inv): self
    {
        $this->num_inv = $num_inv;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|LigneInventaire[]
     */
    public function getLigneInventaires(): Collection
    {
        return $this->ligneInventaires;
    }

    public function addLigneInventaire(LigneInventaire $ligneInventaire): self
    {
        if (!$this->ligneInventaires->contains($ligneInventaire)) {
            $this->ligneInventaires[] = $ligneInventaire;
            $ligneInventaire->setInventaire($this);
        }

        return $this;
    }

    public function removeLigneInventaire(LigneInventaire $ligneInventaire): self
    {
        if ($this->ligneInventaires->contains($ligneInventaire)) {
            $this->ligneInventaires->removeElement($ligneInventaire);
            // set the owning side to null (unless already changed)
            if ($ligneInventaire->getInventaire() === $this) {
                $ligneInventaire->setInventaire(null);
            }
        }

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
}
