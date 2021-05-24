<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnneeRepository")
 */
class Annee
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
    private $libele_an;

    /**
     * @ORM\Column(type="boolean")
     */
    private $courante;

    /**
     * @ORM\OneToMany(targetEntity=Sortie::class, mappedBy="annee")
     */
    private $sorties;

    public function __construct()
    {
        $this->sorties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibeleAn(): ?string
    {
        return $this->libele_an;
    }

    public function setLibeleAn(string $libele_an): self
    {
        $this->libele_an = $libele_an;

        return $this;
    }

    public function getCourante(): ?bool
    {
        return $this->courante;
    }

    public function setCourante(bool $courante): self
    {
        $this->courante = $courante;

        return $this;
    }

    /**
     * @return Collection|Sortie[]
     */
    public function getSorties(): Collection
    {
        return $this->sorties;
    }

    public function addSorty(Sortie $sorty): self
    {
        if (!$this->sorties->contains($sorty)) {
            $this->sorties[] = $sorty;
            $sorty->setAnnee($this);
        }

        return $this;
    }

    public function removeSorty(Sortie $sorty): self
    {
        if ($this->sorties->contains($sorty)) {
            $this->sorties->removeElement($sorty);
            // set the owning side to null (unless already changed)
            if ($sorty->getAnnee() === $this) {
                $sorty->setAnnee(null);
            }
        }

        return $this;
    }
    public  function __toString()
    {
        return $this->libele_an;
        // TODO: Implement __toString() method.
    }
}
