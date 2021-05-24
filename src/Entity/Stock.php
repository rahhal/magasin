<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StockRepository")
 */
class Stock
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
     * @ORM\Column(type="integer")
     */
    private $qte;

    /**
     * @ORM\Column(type="integer")
     */
    private $qte_reste;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="stocks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\LigneEntree", inversedBy="stocks",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $ligne_entree;

    /**
     * @ORM\ManyToMany(targetEntity=LigneSortie::class, mappedBy="stocks")
     */
    private $ligneSorties;

    /**
     * @ORM\OneToMany(targetEntity=LigneInventaire::class, mappedBy="stock")
     */
    private $ligneInventaires;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="stocks")
     */
    private $user;
   

    public function __construct()
    {
        $this->ligneSorties = new ArrayCollection();
        $this->ligneInventaires = new ArrayCollection();
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

    public function getQte(): ?int
    {
        return $this->qte;
    }

    public function setQte(int $qte): self
    {
        $this->qte = $qte;

        return $this;
    }

    public function getQteReste(): ?int
    {
        return $this->qte_reste;
    }

    public function setQteReste(int $qte_reste): self
    {
        $this->qte_reste = $qte_reste;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getLigneEntree(): ?LigneEntree
    {
        return $this->ligne_entree;
    }

    public function setLigneEntree(?LigneEntree $ligne_entree): self
    {
        $this->ligne_entree = $ligne_entree;

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
            $ligneSorty->addStock($this);
        }

        return $this;
    }

    public function removeLigneSorty(LigneSortie $ligneSorty): self
    {
        if ($this->ligneSorties->contains($ligneSorty)) {
            $this->ligneSorties->removeElement($ligneSorty);
            $ligneSorty->removeStock($this);
        }

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
            $ligneInventaire->setStock($this);
        }
        return $this;
    }

    public function removeLigneInventaire(LigneInventaire $ligneInventaire): self
    {
        if ($this->ligneInventaires->contains($ligneInventaire)) {
            $this->ligneInventaires->removeElement($ligneInventaire);
            // set the owning side to null (unless already changed)
            if ($ligneInventaire->getStock() === $this) {
                $ligneInventaire->setStock(null);
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

    public  function __toString()
    {
        // TODO: Implement __toString() method.
        $q = $this->getQteReste();
        return (string)$q;

        // return " ";

    }
}
