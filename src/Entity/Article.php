<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
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
    private $libele;

    /**
     * @ORM\Column(type="integer")
     */
    private $qte_min;

  

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LigneEntree", mappedBy="article")
     */
    private $ligneEntrees;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Stock", mappedBy="article")
     */
    private $stocks;

    /**
     * @ORM\Column(type="integer")
     */
    private $qte_ini;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $remarque;

    /**
     * @ORM\OneToMany(targetEntity=LigneSortie::class, mappedBy="article")
     */
    private $ligneSorties;

    /**
     * @ORM\OneToMany(targetEntity=LigneInventaire::class, mappedBy="article")
     */
    private $ligneInventaires;
     /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="articles")
     */
    private $user;

    public function __construct()
    {
        $this->ligneEntrees = new ArrayCollection();
        $this->stocks = new ArrayCollection();
        $this->ligneSorties = new ArrayCollection();
        $this->ligneInventaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibele(): ?string
    {
        return $this->libele;
    }

    public function setLibele(string $libele): self
    {
        $this->libele = $libele;

        return $this;
    }

    public function getQteMin(): ?int
    {
        return $this->qte_min;
    }

    public function setQteMin(int $qte_min): self
    {
        $this->qte_min = $qte_min;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

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
            $ligneEntree->setArticle($this);
        }

        return $this;
    }

    public function removeLigneEntree(LigneEntree $ligneEntree): self
    {
        if ($this->ligneEntrees->contains($ligneEntree)) {
            $this->ligneEntrees->removeElement($ligneEntree);
            // set the owning side to null (unless already changed)
            if ($ligneEntree->getArticle() === $this) {
                $ligneEntree->setArticle(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this ->libele;
    }

    /**
     * @return Collection|Stock[]
     */
    public function getStocks(): Collection
    {
        return $this->stocks;
    }

    public function addStock(Stock $stock): self
    {
        if (!$this->stocks->contains($stock)) {
            $this->stocks[] = $stock;
            $stock->setArticle($this);
        }

        return $this;
    }

    public function removeStock(Stock $stock): self
    {
        if ($this->stocks->contains($stock)) {
            $this->stocks->removeElement($stock);
            // set the owning side to null (unless already changed)
            if ($stock->getArticle() === $this) {
                $stock->setArticle(null);
            }
        }

        return $this;
    }

    public function getQteIni(): ?int
    {
        return $this->qte_ini;
    }

    public function setQteIni(int $qte_ini): self
    {
        $this->qte_ini = $qte_ini;

        return $this;
    }

    public function getRemarque(): ?string
    {
        return $this->remarque;
    }

    public function setRemarque(?string $remarque): self
    {
        $this->remarque = $remarque;

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
            $ligneSorty->setArticles($this);
        }

        return $this;
    }

    public function removeLigneSorty(LigneSortie $ligneSorty): self
    {
        if ($this->ligneSorties->contains($ligneSorty)) {
            $this->ligneSorties->removeElement($ligneSorty);
            // set the owning side to null (unless already changed)
            if ($ligneSorty->getArticles() === $this) {
                $ligneSorty->setArticles(null);
            }
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
            $ligneInventaire->setArticles($this);
        }

        return $this;
    }

    public function removeLigneInventaire(LigneInventaire $ligneInventaire): self
    {
        if ($this->ligneInventaires->contains($ligneInventaire)) {
            $this->ligneInventaires->removeElement($ligneInventaire);
            // set the owning side to null (unless already changed)
            if ($ligneInventaire->getArticles() === $this) {
                $ligneInventaire->setArticles(null);
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
