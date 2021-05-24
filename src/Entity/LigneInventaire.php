<?php

namespace App\Entity;

use App\Repository\LigneInventaireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LigneInventaireRepository::class)
 */
class LigneInventaire
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
    private $qteInv;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="ligneInventaires")
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity=Inventaire::class, inversedBy="ligneInventaires",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $inventaire;

    /**
     * @ORM\ManyToOne(targetEntity=Stock::class, inversedBy="ligneInventaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $stock;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQteInv(): ?int
    {
        return $this->qteInv;
    }

    public function setQteInv(int $qteInv): self
    {
        $this->qteInv = $qteInv;

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

    public function getInventaire(): ?Inventaire
    {
        return $this->inventaire;
    }

    public function setInventaire(?Inventaire $inventaire): self
    {
        $this->inventaire = $inventaire;

        return $this;
    }

    public function getStock(): ?Stock
    {
        return $this->stock;
    }

    public function setStock(?Stock $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

}
