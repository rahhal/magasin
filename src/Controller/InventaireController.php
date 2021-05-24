<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\ArticleSearch;
use App\Entity\Categorie;
use App\Entity\Inventaire;
use App\Entity\LigneInventaire;
use App\Entity\Societe;
use App\Entity\Stock;
use App\Entity\StockSearch;
use App\Entity\Type;
use App\Form\ArticleSearchType;
use App\Form\InventaireType;
use App\Form\LigneInventaireType;
use App\Form\StockSearchType;
use App\Repository\InventaireRepository;
use App\Repository\LigneInventaireRepository;
use App\Repository\StockRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;
// Include JSON Response
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/inventaire")
 * @IsGranted("ROLE_ENTREPRISE", message="ليس لديك الحق في الدخول الى هذه الصفحةّ")
 */
class InventaireController extends AbstractController
{
    /**
     * @Route("/list", name="ligne_inventaire_list", methods={"GET"})
     */
    public function list(InventaireRepository $inventaireRepository, LigneInventaireRepository $ligneInventaireRepository): Response
    {
        $user= $this->getUser();


       // $inv= $inventaireRepository->findOneBy(['date' => new \Datetime(date('y-m-d'))]);
       // $inv= $inventaireRepository->findBy(['date' => new \Datetime('now')]);
        $inv= $inventaireRepository->getByCurrentUser($user->getId());

       // dump($inv);die();
        $ligneInventaires= $ligneInventaireRepository->findBy(['inventaire'=> $inv]);


    if (!$inv)

        //throw $this->createNotFoundException('لم تقم يالجرد اليومي بهذا اليوم');
     $this->addFlash('danger', 'لم تقم يالجرد اليومي بهذا اليوم  ');
        //return $this->redirectToRoute("inventaire_new");
        //dump($ligneInventaires);die();

        return $this->render('inventaire/list.html.twig', [
            'ligne_inventaires' =>  $ligneInventaires
            // 'ligne_inventaires' =>  $ligneInventaireRepository->findAll()
        ]);
    }

    /**
     * @Route("/annuel", name="inventaire_index")
     *
     */
    public function index( Request $request, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $inventaires = $paginator->paginate(
            $result = $em->getRepository(Inventaire::class)
                ->findInventaireByUser($this->getUser()->getId()),
            $request->query->getInt('page', 1), 10
        );
       // dump($inventaires);die();
        //$inventaires = $em->getRepository(Inventaire::class)->findAll();
        return $this->render('inventaire/index.html.twig', array(
            'inventaires' => $inventaires,
            // 'sousMenu' => array(['nom' => 'المواد', 'url' => 'article_new'])

        ));
    }




    /**
     * @Route("/", name="inventaire_new")
     * @Route("/edit/{id}", name="inventaire_edit")
     *
     */
    public function new($id = null, Request $request, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        if (is_null($id))
        {$inventaire = new Inventaire();

        $form = $this->createForm(InventaireType::class, $inventaire);
        $form->handleRequest($request);
        if ($request->isMethod('POST') && $form->isValid()) {

            $user = $this->getUser();
            $inventaire->setUser($user);

            $em->persist($inventaire);
            $em->flush();

            $this->addFlash('success', "تمت العملية بنجاح");
            return $this->redirectToRoute("inventaire_show", ['id'=> $inventaire->getId()]);
        }}
        else{
            $inventaire = $em->find(Inventaire::class, $id);

        $form = $this->createForm(InventaireType::class, $inventaire);
        $form->handleRequest($request);
        if ($request->isMethod('POST') && $form->isValid()) {

            $user = $this->getUser();
            $inventaire->setUser($user);

            $em->persist($inventaire);
            $em->flush();

            $this->addFlash('success', "تمت العملية بنجاح");
            return $this->redirectToRoute("inventaire_new");
        }}
        $inventaires = $paginator->paginate(
            $result = $em->getRepository(Inventaire::class)
                ->findInventaireByUser($this->getUser()->getId()),
            $request->query->getInt('page', 1), 10
        );
        //$inventaires = $em->getRepository(Inventaire::class)->findAll();
        return $this->render('inventaire/new.html.twig', array(
            'form' => $form->createView(),
            'inventaires' => $inventaires,
            // 'sousMenu' => array(['nom' => 'المواد', 'url' => 'article_new'])

        ));
    }

    /**
     * @Route("/new", name="inventaire_ajout", methods={"GET","POST"})
     */
    public function ajout(Request $request): Response
    {
        $inventaire = new Inventaire();
        $form = $this->createForm(InventaireType::class, $inventaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($inventaire);
            $entityManager->flush();

            return $this->redirectToRoute('inventaire_index');
        }

        return $this->render('inventaire/new.html.twig', [
            'inventaire' => $inventaire,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/show", name="inventaire_show", methods={"GET", "POST"})
     */
    public function show( Inventaire $inventaire, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $ligneInventaire = new LigneInventaire();

        $form = $this->createForm(LigneInventaireType::class, $ligneInventaire);
        $form->handleRequest($request);

        if ($request->isMethod('POST') && $form->isValid())
        {
            $ligneInventaire->setInventaire($inventaire);


            $em->persist($ligneInventaire);
            $em->persist($inventaire);
            $em->flush();
            $this->addFlash('success', "تمت العملية بنجاح");
            //  dump($ligneEntree);die();
            return $this->redirectToRoute("inventaire_show", ['id' => $inventaire->getId()]);
            // return $this->redirectToRoute("entree_show", ['id'=> $ligneEntree->getEntree()->getId()]);
        }

        $ligneInventaires = $em->getRepository(LigneInventaire::class)->findAll();
        return $this->render('inventaire/show.html.twig', [
            'inventaire' => $inventaire,
            'ligne_inventaires' => $ligneInventaires,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/{id}/edit", name="inventaire_editt", methods={"GET","POST"})
     */
    public function editt(Request $request, Inventaire $inventaire): Response
    {
        $form = $this->createForm(InventaireType::class, $inventaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('inventaire_new');
        }

        return $this->render('inventaire/edit.html.twig', [
            'inventaire' => $inventaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="inventaire_delete")
     */

    /*public function delete(Request $request, Inventaire $inventaire): Response
    {
        if ($this->isCsrfTokenValid('delete'.$inventaire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($inventaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('inventaire_new');
    }*/
    public function delete(Inventaire $id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        $this->addFlash('success', "تم الحذف بنجاح");
        return $this->redirectToRoute('inventaire_new');
    }



    /**
     * @Route("/search/inventaire", name="inventaire_search")
     *
     */
    public function search( Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $search= new ArticleSearch();
        // $search->page = $request->get('page', 1);
        $form_search = $this->createForm(ArticleSearchType::class, $search);
        $form_search->handleRequest($request);
        if ($form_search->isSubmitted() && $form_search->isValid()) {
            $categorie = $form_search["categorie"]->getData();
            $type = $form_search["type"]->getData();

            return $this->redirectToRoute('pdfinv',[
                'categorie'=> $categorie->getId(),
                'type'=> $type->getId()
            ]);
        }
        $articles = $em->getRepository(Article::class)->findSearch($search);
        // dump($articles);die();

        return $this->render('search/search1.html.twig', array(
            //  'form' => $form->createView(),
            'articles' => $articles,
            'form_search' => $form_search->createView(),
        ));
    }
// ------- طباعة بطاقة جرد   ----------             //
    /**
     * @Route("/pdfinv/categorie/{categorie}/type/{type}", name="pdfinv")
     * @return response
     */
    public function pdfinvAction($categorie, $type)
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
        $id=$this->getUser()->getId();
      $ligneInventaires = $this->getDoctrine()
            ->getRepository(LigneInventaire::class)
            ->findByArticle($ids);
        // dump($ligneInventaires);die();
        $societe=$this->getDoctrine()
            ->getRepository(Societe::class)->findSocieteByUser($id);
        $cat=$this->getDoctrine()->getRepository(Categorie::class)->find($categorie);
        $tp=$this->getDoctrine()->getRepository(Type::class)->find($type);

        $template = $this->renderView('pdf/inventaire.html.twig', [
            'ligneInentaires'=> $ligneInventaires,
            'articles'=>$articles,
            'title' =>"بطاقة جرد",
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
     * @Route("/print/inv", name="inv_pdf")
     *
     */

    public function printAction()
    {
         $id=$this->getUser()->getId();
        $ligneInentaire= $this->getDoctrine()
            ->getRepository(LigneInventaire::class)->findAll();
        $societe=$this->getDoctrine()
            ->getRepository(Societe::class)->findSocieteByUser($id);
        $articles=$this->getDoctrine()
            ->getRepository(Article::class)->getArticleByUser($id);
        $html = $this->renderView('pdf/inventaire.html.twig', array(
            'ligneInentaires'=> $ligneInentaire,
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
}
