<?php
namespace App\Entity;

class StockSearch{

    /**
     * @var int
     */
    public $page = 1;

    /**
     * @var string
     */
    public $q = '';
    /**
     * @var Categorie
     */
    public $categorie;

    /**
     * @var Type
     */
    public $type;
    /**
     * @var Date
     */
    public $date;

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @param int $page
     */
    public function setPage(int $page)
    {
        $this->page = $page;
    }


    /**
     * @return Categorie
     */
    public function getCategories(): Categorie
    {
        return $this->getCategories();
    }

    /**
     * @param Categorie $categorie
     */
    public function setCategorie(Categorie $categorie)
    {
        $this->categorie = $categorie;
    }

    /**
     * @return Type
     */
    public function getTypes(): Type
    {
        return $this->getTypes();
    }

    /**
     * @param Type $type
     */
    public function setType(Type $type)
    {
        $this->type = $type;
    }
    /**
     * @return \Symfony\Component\Validator\Constraints\Date
     */
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

}