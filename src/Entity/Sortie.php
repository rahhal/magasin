<?php

namespace App\Entity;

use App\Repository\SortieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SortieRepository::class)
 */
class Sortie
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
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bon_sortie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $num;

    /**
     * @ORM\OneToMany(targetEntity=LigneSortie::class, mappedBy="sortie")
     */
    private $ligneSorties;

    /**
     * @ORM\ManyToOne(targetEntity=Annee::class, inversedBy="sorties")
     */
    private $annee;

    /**
     * @ORM\ManyToOne(targetEntity=Benificiaire::class, inversedBy="sorties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $benificiaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="sorties")
     */
    private $user;

    public function __construct()
    {
        $this->ligneSorties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getBonSortie(): ?string
    {
        return $this->bon_sortie;
    }

    public function setBonSortie(string $bon_sortie): self
    {
        $this->bon_sortie = $bon_sortie;

        return $this;
    }

    public function getNum(): ?string
    {
        return $this->num;
    }

    public function setNum(string $num): self
    {
        $this->num = $num;

        return $this;
    }

    /**
     * @return Collection|LigneSortie[]
     */
    public function getLigneSorties(): Collection
    {
        return $this->ligneSorties;
    }

    public function addLigneSorty(LigneSortie $ligneSorty): self
    {
        if (!$this->ligneSorties->contains($ligneSorty)) {
            $this->ligneSorties[] = $ligneSorty;
            $ligneSorty->setSortie($this);
        }

        return $this;
    }

    public function removeLigneSorty(LigneSortie $ligneSorty): self
    {
        if ($this->ligneSorties->contains($ligneSorty)) {
            $this->ligneSorties->removeElement($ligneSorty);
            // set the owning side to null (unless already changed)
            if ($ligneSorty->getSortie() === $this) {
                $ligneSorty->setSortie(null);
            }
        }

        return $this;
    }

    public function getAnnee(): ?Annee
    {
        return $this->annee;
    }

    public function setAnnee(?Annee $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getBenificiaire(): ?Benificiaire
    {
        return $this->benificiaire;
    }

    public function setBenificiaire(?Benificiaire $benificiaire): self
    {
        $this->benificiaire = $benificiaire;

        return $this;
    }
    public  function __toString()
    {
        return $this->bon_sortie;
        // TODO: Implement __toString() method.
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
