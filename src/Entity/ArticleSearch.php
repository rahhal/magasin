<?php
namespace App\Entity;

class ArticleSearch{

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



}