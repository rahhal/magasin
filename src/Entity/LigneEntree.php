<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LigneEntreeRepository")
 */
class LigneEntree
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $qte_entr;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $qte_reste;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="ligneEntrees")
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Entree", inversedBy="ligneEntrees")
     */
    private $entree;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Stock", mappedBy="ligne_entree")
     */
    private $stocks;


    public function __construct()
    {
        $this->stocks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQteEntr(): ?int
    {
        return $this->qte_entr;
    }

    public function setQteEntr(int $qte_entr): self
    {
        $this->qte_entr = $qte_entr;

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

    public function getEntree(): ?Entree
    {
        return $this->entree;
    }

    public function setEntree(?Entree $entree): self
    {
        $this->entree = $entree;

        return $this;
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
            $stock->setLigneEntree($this);
        }

        return $this;
    }

    public function removeStock(Stock $stock): self
    {
        if ($this->stocks->contains($stock)) {
            $this->stocks->removeElement($stock);
            // set the owning side to null (unless already changed)
            if ($stock->getLigneEntree() === $this) {
                $stock->setLigneEntree(null);
            }
        }

        return $this;
    }

}
