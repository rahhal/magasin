<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EntreeRepository")
 */
class Entree
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateEntree;

    /**
     * @ORM\Column(type="date")
     */
    private $date_bc;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $num_entree;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $num_bc;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Fournisseur", inversedBy="entrees")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fournisseur;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LigneEntree", mappedBy="entree")
     */
    private $ligneEntrees;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="entrees")
     */
    private $user;

    public function __construct()
    {
        $this->ligneEntrees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEntree(): ?\DateTimeInterface
    {
        return $this->dateEntree;
    }

    public function setDateEntree(\DateTimeInterface $dateEntree): self
    {
        $this->dateEntree = $dateEntree;

        return $this;
    }

    public function getDateBc(): ?\DateTimeInterface
    {
        return $this->date_bc;
    }

    public function setDateBc(\DateTimeInterface $date_bc): self
    {
        $this->date_bc = $date_bc;

        return $this;
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

    public function getNumEntree(): ?string
    {
        return $this->num_entree;
    }

    public function setNumEntree(string $num_entree): self
    {
        $this->num_entree = $num_entree;

        return $this;
    }

    public function getNumBc(): ?string
    {
        return $this->num_bc;
    }

    public function setNumBc(string $num_bc): self
    {
        $this->num_bc = $num_bc;

        return $this;
    }

    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseur $fournisseur): self
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    /**
     * @return Collection|LigneEntree[]
     */
    public function getLigneEntrees(): Collection
    {
        return $this->ligneEntrees;
    }

    public function addLigneEntree(LigneEntree $ligneEntree): self
    {
        if (!$this->ligneEntrees->contains($ligneEntree)) {
            $this->ligneEntrees[] = $ligneEntree;
            $ligneEntree->setEntree($this);
        }

        return $this;
    }

    public function removeLigneEntree(LigneEntree $ligneEntree): self
    {
        if ($this->ligneEntrees->contains($ligneEntree)) {
            $this->ligneEntrees->removeElement($ligneEntree);
            // set the owning side to null (unless already changed)
            if ($ligneEntree->getEntree() === $this) {
                $ligneEntree->setEntree(null);
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
