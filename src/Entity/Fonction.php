<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FonctionRepository")
 */
class Fonction
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
    private $fonction;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $remarque;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="fonctions")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Benificiaire", mappedBy="fonction")
     */
    private $benificiaires;

    public function __construct()
    {
        $this->benificiaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(string $fonction): self
    {
        $this->fonction = $fonction;

        return $this;
    }

    public function getRemarque(): ?string
    {
        return $this->remarque;
    }

    public function setRemarque(string $remarque): self
    {
        $this->remarque = $remarque;

        return $this;
    }

    /**
     * @return Collection|Benificiaire[]
     */
    public function getBenificiaires(): Collection
    {
        return $this->benificiaires;
    }

    public function addBenificiaire(Benificiaire $benificiaire): self
    {
        if (!$this->benificiaires->contains($benificiaire)) {
            $this->benificiaires[] = $benificiaire;
            $benificiaire->setFonction($this);
        }

        return $this;
    }

    public function removeBenificiaire(Benificiaire $benificiaire): self
    {
        if ($this->benificiaires->contains($benificiaire)) {
            $this->benificiaires->removeElement($benificiaire);
            // set the owning side to null (unless already changed)
            if ($benificiaire->getFonction() === $this) {
                $benificiaire->setFonction(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        // TODO: Implement __toString() method.
      return  $this ->fonction;
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
