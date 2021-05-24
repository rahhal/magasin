<?php
namespace App\Controller;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Entree;
use App\Entity\LigneEntree;
use App\Entity\LigneSortie;
use App\Entity\Societe;
use App\Entity\Sortie;
use App\Entity\Stock;
use App\Entity\StockSearch;
use App\Entity\StockSearchArticle;
use App\Entity\Type;
use App\Form\Stock1Type;
use App\Form\Stock2Type;
use App\Form\StockSearchArticleType;
use App\Form\StockSearchType;
use App\Form\StockType;
use App\Repository\StockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/statistique")
 * *
 */
class StatistiqueController extends AbstractController
{
    /**
     * @Route("/", name="pourcentage")
     */

    public function Pourcentage()
    {
        $stocks = $this->getDoctrine()->getRepository(Stock::class)
            ->getStockByUser($this->getUser()->getId());

        $cat=[];$pourcentage=[];$stck=[];
        foreach ($stocks as $stock) {
            $article = $stock->getArticle()->getCategorie()->getDesignation();
            $cat[]= $stock->getArticle()
                ->getCategorie()->getDesignation()
            ;// array_push($categories, $cat);
            $stck[]= $stock->getArticle();

        }
        $sum= count($stck);//somme des categories dans le stock
       // dump($sum);die();
        $categories=[];
        $freq = array_count_values($cat);
        foreach ($freq as $v => $f) {

            $pourcentage[]= round(($f/$sum)*100,2);
            $categories[]=$v;
        }

       // dump( $pourcentage, $categories);die();

        return $this->render('statistique\pourcentage.html.twig',[
            'stocks'=>$stocks,
            'categories' => json_encode($categories),
            'pourcentages'=> json_encode($pourcentage),
        ]);
    }
    /**
     * @Route("/search2/stock", name="stock_search2")
     *
     */
    public function search2( Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $search= new StockSearch();
        // $search->page = $request->get('page', 1);
        $form_search = $this->createForm(StockSearchType::class, $search);
        $form_search->handleRequest($request);
        if ($form_search->isSubmitted() && $form_search->isValid()) {
            $categorie = $form_search["categorie"]->getData();
            // $type = $form_search["type"]->getData();
            $date = $form_search["date"]->getData();
            return $this->redirectToRoute('stat',[
                'categorie'=> $categorie->getId(),
                //'type'=> $type->getId()
            ]);
        }
        $stocks = $em->getRepository(Stock::class)->findSearch($search);
        // dump($articles);die();

       /*  return $this->render('search/stock.html.twig', array(
            //  'form' => $form->createView(),
            'stocks' => $stocks,
            'form_search' => $form_search->createView(),
        )); */
        return $this->render('search/stat2.html.twig', array(
            //  'form' => $form->createView(),
            'stocks' => $stocks,
            'form_search' => $form_search->createView(),
        ));
    }
    /**
     * @Route("/stat/article/{categorie}", name="stat")
     */

    public function stat($categorie)
    {
        $articles = $this->getDoctrine()->getRepository(Article::class)
            ->getArticlesByCategorie($categorie);
        // dump($articles);die();
        $ids = array();  //creation de tableau vide
        foreach($articles as $article) {
            $id= $article->getId();
            array_push($ids, $id);//remplissage du tableau  avec les ids
        }
        $stocks = $this->getDoctrine()->getRepository(Stock::class)
            ->findByArticle($ids);
        // dump($stocks);die();
        $art=array();$qte=array();
        foreach ($stocks as $stock) {
            $a = $stock->getArticle()->getLibele();
            $q = $stock->getQteReste();
            array_push($art, $a);
            array_push($qte, $q);
        }
        //  dump($art);die();
        // dump($art, $qte);die();
        $cat=$this->getDoctrine()->getRepository(Categorie::class)->find($categorie);
        return $this->render('statistique/stat1.html.twig', array(
            'qte'=> json_encode($qte),
            'stocks'=> $stocks,
            'article' => json_encode($art),
            'categorie'=> $cat,
            //'title' =>"احصائيات",
        ));
    }
    //-------------formulaire de recherche par date et categorie
    /**
     * @Route("/search3/entree", name="entree_search3")
     *
     */
    public function search3( Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $search= new StockSearch();
        // $search->page = $request->get('page', 1);
        $form_search = $this->createForm(StockSearchType::class, $search);
        $form_search->handleRequest($request);
        if ($form_search->isSubmitted() && $form_search->isValid()) {
            $categorie = $form_search["categorie"]->getData();
             $date = $form_search["date"]->getData();


            $month=date_format($date, 'm');
            $year = date_format($date, 'Y');

        //dump($categorie, $date);die();
            return $this->redirectToRoute('stat3',[
                'categorie'=> $categorie->getId(),
                'month'=> $month,
                'year'=>$year
            ]);
        }
        // dump($articles);die();

        return $this->render('search/stat.html.twig', array(
            //  'form' => $form->createView(),
            //'stocks' => $stocks,
            'form_search' => $form_search->createView(),
        ));
    }
    /**
     * @Route("/stat3/{categorie}/{year}/{month}", name="stat3")
     */

    public function stat3($categorie,$year, $month)
    {

        $articles = $this->getDoctrine()->getRepository(Article::class)
            ->getArticlesByCategorie($categorie);
        // dump($articles);die();
        $idarticles = array(); $arti = array(); //creation de tableau vide
        foreach($articles as $article) {
            $id= $article->getId();
            $art= $article->getLibele();
            array_push($idarticles, $id);//remplissage du tableau  avec les ids
            array_push($arti, $art);
        }
       // dump($idarticles);die();
        // recuperer les entrees à une année et mois données etmettre ses ids dans un tableau ids[]
        $entrees = $this->getDoctrine()->getRepository(Entree::class)
            ->getEntreesByMonth($year, $month);
       //  dump($entrees);die();
        $ids = [];$ligneEntrees=[];  //creation de tableau vide
        foreach($entrees as $entree) {
            $id= $entree->getId();
            array_push($ids, $id);//remplissage du tableau  avec les ids
        }
            foreach($idarticles as $idarticle) {
                $les = $this->getDoctrine()->getRepository(LigneEntree::class)
                    //-> findLigneEntreeBySum($ids, $idarticle);
                    ->findLigneEntreeBySum($idarticle, $ids);

                array_push($ligneEntrees, $les);
            }

        $cat=$this->getDoctrine()->getRepository(Categorie::class)->find($categorie);
        return $this->render('statistique/stat2.html.twig', array(
            'ligneEntrees'=> json_encode($ligneEntrees),
           // 'stocks'=> $stocks,
            'articles' => json_encode($arti),
            'categorie'=> $cat,
            'month' =>$month,
        ));
    }
    //-------statistique de sortie
    /**
     * @Route("/search4/sortie", name="sortie_search4")
     *
     */
    public function search4( Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $search= new StockSearch();
        // $search->page = $request->get('page', 1);
        $form_search = $this->createForm(StockSearchType::class, $search);
        $form_search->handleRequest($request);
        if ($form_search->isSubmitted() && $form_search->isValid()) {
            $categorie = $form_search["categorie"]->getData();
            $date = $form_search["date"]->getData();


            $month=date_format($date, 'm');
            $year = date_format($date, 'Y');

            //dump($categorie, $date);die();
            return $this->redirectToRoute('stat4',[
                'categorie'=> $categorie->getId(),
                'month'=> $month,
                'year'=>$year
            ]);
        }
        // dump($articles);die();

        return $this->render('search/sortieSearch.html.twig', array(
            //  'form' => $form->createView(),
            //'stocks' => $stocks,
            'form_search' => $form_search->createView(),
        ));
    }
    /**
     * @Route("/stat4/{categorie}/{year}/{month}", name="stat4")
     */

    public function stat4($categorie,$year, $month)
    {

        $articles = $this->getDoctrine()->getRepository(Article::class)
            ->getArticlesByCategorie($categorie);
        // dump($articles);die();
        $idarticles = array(); $arti = array(); //creation de tableau vide
        foreach($articles as $article) {
            $id= $article->getId();
            $art= $article->getLibele();
            array_push($idarticles, $id);//remplissage du tableau  avec les ids
            array_push($arti, $art);
        }
        // dump($idarticles);die();
        // recuperer les entrees à une année et mois données etmettre ses ids dans un tableau ids[]
        $sorties = $this->getDoctrine()->getRepository(Sortie::class)
            ->getSortiesByMonth($year, $month);
        //  dump($entrees);die();
        $ids = [];$ligneSorties=[];  //creation de tableau vide
        foreach($sorties as $sortie) {
            $id= $sortie->getId();
            array_push($ids, $id);//remplissage du tableau  avec les ids
        }
        foreach($idarticles as $idarticle) {
            $les = $this->getDoctrine()->getRepository(LigneSortie::class)
                //-> findLigneEntreeBySum($ids, $idarticle);
                ->getSumQte($idarticle, $ids);

            array_push($ligneSorties, $les);
        }

        $cat=$this->getDoctrine()->getRepository(Categorie::class)->find($categorie);
        return $this->render('statistique/sortie.html.twig', array(
            'ligneSorties'=> json_encode($ligneSorties),
            // 'stocks'=> $stocks,
            'articles' => json_encode($arti),
            'categorie'=> $cat,
            'month' =>$month,
        ));
    }

}