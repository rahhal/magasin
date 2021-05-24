<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Entree;
use App\Entity\Sortie;

use App\Entity\LigneEntree;
use App\Entity\LigneSortie;
use App\Entity\Societe;
use App\Entity\Stock;
use App\Entity\StockSearch;
use App\Entity\StockSearchArticle;
use App\Entity\Type;
use App\Form\Stock1Type;
use App\Form\StockSearchArticleType;
use App\Form\StockSearchType;
use App\Form\StockType;
use App\Repository\StockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/stock")
 * @IsGranted("ROLE_ENTREPRISE", message="ليس لديك الحق في الدخول الى هذه الصفحةّ")
 */
class StockController extends AbstractController
{
    /**
     * @Route("/", name="stock_index", methods={"GET"})
     */
    public function index(StockRepository $stockRepository, Request $request, PaginatorInterface $paginator): Response
    {$em= $entityManager = $this->getDoctrine()->getManager();
        $stocks = $paginator->paginate(
            $result = $em->getRepository(Stock::class)
                ->getStockByUser($this->getUser()->getId()), // Requête contenant les données à paginer (ici nos annees)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6 // Nombre de résultats par page
        );
        return $this->render('stock/index.html.twig', [
            'stocks' => $stocks,
        ]);
    }

    /**
     * @Route("/new", name="stock_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $stock = new Stock();
        $form = $this->createForm(StockType::class, $stock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($stock);
            $entityManager->flush();

            return $this->redirectToRoute('stock_index');
        }

        return $this->render('stock/new.html.twig', [
            'stock' => $stock,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/stockinitial", name="stock_ini", methods={"GET"})
     */
    public function stockinitial(Request $request): Response
    {
        // $em = $this->getDoctrine()->getManager();
        $articles=$this->getDoctrine()
            ->getRepository(Article::class)
            ->getArticleByUser($this->getUser()->getId());

        // var_dump($article);die();
        // $stck_ini= $em->getRepository(Article::class)->stockIni();
        return $this->render('stock/stockIni.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/{id}", name="stock_show", methods={"GET"})
     */
    public function show(Stock $stock): Response
    {
        return $this->render('stock/show.html.twig', [
            'stock' => $stock,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="stock_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Stock $stock): Response
    {
        $form = $this->createForm(StockType::class, $stock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('stock_index');
        }

        return $this->render('stock/edit.html.twig', [
            'stock' => $stock,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="stock_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Stock $stock): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stock->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($stock);
            $entityManager->flush();
        }

        return $this->redirectToRoute('stock_index');
    }
    /**
     * @Route("/search/stock", name="stock_search")
     *
     */
    public function search( Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $search= new StockSearch();
        // $search->page = $request->get('page', 1);
        $form_search = $this->createForm(StockSearchType::class, $search);
        $form_search->handleRequest($request);
        if ($form_search->isSubmitted() && $form_search->isValid()) {
            $categorie = $form_search["categorie"]->getData();
            $type = $form_search["type"]->getData();

            return $this->redirectToRoute('pdf2',[
                'categorie'=> $categorie->getId(),
                'type'=> $type->getId()
            ]);
        }
        $stocks = $em->getRepository(Stock::class)->findSearch($search);
        // dump($articles);die();

        return $this->render('search/stock.html.twig', array(
            //  'form' => $form->createView(),
            'stocks' => $stocks,
            'form_search' => $form_search->createView(),
        ));
    }

 /**
    * @Route("/pdf2/categorie/{categorie}/type/{type}", name="pdf2")
    * @return response
    */
    public function pdf2Action($categorie, $type)
    {
        $articles = $this->getDoctrine()
        ->getRepository(Article::class)->getArticles($categorie, $type);
        // dump($articles);die();
        $ids = array();  //creation de tableau vide
        foreach($articles as $article) {
            $id= $article->getId();
            array_push($ids, $id);//remplissage du tableau  avec les ids
        }
       // dump($ids);die();
      
          $stocks = $this->getDoctrine()
                        ->getRepository(Stock::class)
                       // ->findOneBy(['article' => $article]);
                        // ->findByArticle($article->getId()); 
                        ->findByArticle($ids); 
  // dump($stocks);die();
   $societe=$this->getDoctrine()
            ->getRepository(Societe::class)->findSocieteByUser($this->getUser()->getId());
        $cat=$this->getDoctrine()->getRepository(Categorie::class)->find($categorie);
        $tp=$this->getDoctrine()->getRepository(Type::class)->find($type);

        $template = $this->renderView('pdf/stock0.html.twig', [
            'stocks'=> $stocks,
            'title' =>"المخزون الحالي",
            'categorie'=>$cat,
            'type' => $tp,
            'societe'=> $societe
            ]);
        
        // Create an instance of the class:
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetDirectionality('rtl');
        $mpdf = new \Mpdf\Mpdf([
            'default_font_size' => 14,
            'default_font' => 'lateef'
        ]);
        // Write some HTML code:
       // $mpdf->SetHTMLFooter($footer);
        $mpdf->WriteHTML($template);
        // Output a PDF file directly to the browser
        $mpdf->Output();
    }
    /**
     * @Route("/pdf/stck", name="stock_pdf")
     *
     */
    public function pdf()
    {
        $id=$this->getUser()->getId();
        $stock= $this->getDoctrine()
            ->getRepository(Stock::class)->getStockByUser($id);
        $societe=$this->getDoctrine()
            ->getRepository(Societe::class)->findSocieteByUser($id);
        $articles=$this->getDoctrine()
            ->getRepository(Article::class)->getArticleByUser($id);
        $html = $this->renderView('pdf/stock.html.twig', array(
            'stocks'=> $stock,
            'articles'=>$articles,
            'societe'=> $societe,
            'title' =>"محتويات المخزن",
        ));
//        $footer = $this->renderView('pdf/footer.html.twig', array(
//            'institution'=> $institution,
//        ));
        // Create an instance of the class:
        $mpdf = new \Mpdf\Mpdf([
            'default_font_size' => 12,
            'default_font' => 'lateef'
        ]);
       // $mpdf->AddFontDirectory();
        $mpdf->SetDirectionality('rtl');
        //$mpdf->SetFont('times');
       // $mpdf->pdf_version = '1.5';
        // $mpdf->SetHTMLFooter($footer);
        // Write some HTML code:
        $mpdf->WriteHTML($html);
        // Output a PDF file directly to the browser
        $mpdf->Output();
    }
    /**
     * @Route("/print/stck0", name="stock0_pdf")
     *
     */

    public function printAction()
    {
        //  $id=$this->getUser()->getId();
        $stock= $this->getDoctrine()
            ->getRepository(Stock::class)->findAll();
        $societe=$this->getDoctrine()
            ->getRepository(Societe::class)->findAll();
        $articles=$this->getDoctrine()
            ->getRepository(Article::class)->findAll();
        $html = $this->renderView('pdf/stock0.html.twig', array(
            'stocks'=> $stock,
            'articles'=>$articles,
            'societe'=> $societe,
            'title' =>"طباعة المخزون الحالي",
        ));
//        $footer = $this->renderView('pdf/footer.html.twig', array(
//            'institution'=> $institution,
//        ));
        // Create an instance of the class:
        $mpdf = new \Mpdf\Mpdf([
            'default_font_size' => 12,
            'default_font' => 'lateef'
        ]);
        $mpdf->SetDirectionality('rtl');
        // $mpdf->SetHTMLFooter($footer);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    // ------------------------------طباعة بطاقة مخزون-------------------
    /**
     * @Route("/search1/stock", name="stock_search1")
     *
     */
    public function search1( Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $search= new Stock();
        // $search->page = $request->get('page', 1);
        $form_search = $this->createForm(Stock1Type::class, $search);
        $form_search->handleRequest($request);
        if ($form_search->isSubmitted() && $form_search->isValid()) {

            $article = $form_search["article"]->getData();
            return $this->redirectToRoute('carte',[
                'article'=> $article->getId(),
            ]);
        }
//        $stocks = $em->getRepository(Stock::class)->findSearch($search);
        // dump($articles);die();
        $stocks = $em->getRepository(Stock::class)->getStockByUser($this->getUser()->getId());
        return $this->render('search/carte.html.twig', array(
            //  'form' => $form->createView(),
            'stocks' => $stocks,
            'form_search' => $form_search->createView(),
        ));
    }
    /**
     * @Route("/carte/article/{article}", name="carte")
     */

    public function carteAction($article)
    {
        /* $ligneEntrees = $this->getDoctrine()->getRepository(LigneEntree::class) ->getByArticle($article);
        $ligneSorties = $this->getDoctrine() ->getRepository(LigneSortie::class) ->getByArticle($article);
        $date= new \DateTime('now');
        $entree = $this->getDoctrine()->getRepository(Entree::class) ->findByDate(date_format($date, 'Y'));
         dump($entree);die(); */
       

        //********************************************
        $ligneEntrees = $this->getDoctrine()->getRepository(LigneEntree::class) ->getByArticle($article);
        $ligneSorties = $this->getDoctrine() ->getRepository(LigneSortie::class) ->getByArticle($article);
       
        $date= new \DateTime('now');
        $entrees = $this->getDoctrine()->getRepository(Entree::class) ->findByDate(date_format($date, 'Y'));
        $sorties = $this->getDoctrine()->getRepository(Sortie::class) ->findByDate(date_format($date, 'Y'));

         $dates_ent=array();$dates_sor=array();$dates=array();
         foreach($entrees as $entree)
         {
            $dte= date_format($entree->getDateEntree(), 'Y-m-d');
            array_push($dates_ent, $dte);//remplissage du tableau  avec les ids
         }
         foreach($sorties as $sortie)
         {
            $dte= date_format($sortie->getDate(),'Y-m-d') ;
            array_push($dates_sor, $dte);//remplissage du tableau  avec les ids
         }
         $dates= array_unique(array_merge($dates_ent, $dates_sor));
            // dump($dates_ent, $dates_sor, $dates);die(); 
       


        //***************************************** */ */


        $id= $this->getUser()->getId();
        $societe=$this->getDoctrine()
            ->getRepository(Societe::class)->findSocieteByUser($id);
        $art=$this->getDoctrine()->getRepository(Article::class)->find($article);
        $html = $this->renderView('pdf/carte1.html.twig', array(
               // 'entrees'=> $entrees,
                'ligne_entrees'=> $ligneEntrees,
                'ligne_sorties'=> $ligneSorties,
                'dates'=> $dates,
               // 'stocks'=> $stock,
                //'articles'=>$articles,
                'article' => $art,
                'societe'=> $societe,
                'title' =>"طباعة المخزون الحالي",
        ));
//        $footer = $this->renderView('pdf/footer.html.twig', array(
//            'institution'=> $institution,
//        ));
        // Create an instance of the class:
        $mpdf = new \Mpdf\Mpdf([
            // 'orientation' => 'L',
            // 'format' => [190, 236],
            'format' => 'A4-L',
            'default_font_size' => 12,
            'default_font' => 'lateef'
        ]);
       // $mpdf->Image('assets/images/logo.png');
        $mpdf->SetDirectionality('rtl');
        // $mpdf->SetHTMLFooter($footer);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
    // ------------------------------احصائيات-------------------


}
