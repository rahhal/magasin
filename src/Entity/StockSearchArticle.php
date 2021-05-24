<?php
namespace App\Entity;

class StockSearchArticle{

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
     * @var Article
     */
    public $article;

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
     * @return Article
     */
    public function getArticle(): Article
    {
        return $this->getArticle();
    }

    /**
     * @param Article $article
     */
    public function setArticle(Article $article)
    {
        $this->article = $article;
    }

}