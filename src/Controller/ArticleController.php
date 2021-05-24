<?php


namespace App\Controller;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\ArticleSearch;
use App\Form\ArticleSearchType;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Spipu\Html2Pdf\Html2Pdf;
use mpdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
//use App\Service\Html2Pdf;
//use Spipu\Html2Pdf\Html2Pdf;

/**
 * @Route("/article")
 * @IsGranted("ROLE_ENTREPRISE", message="ليس لديك الحق في الدخول الى هذه الصفحةّ")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="article_new")
     * @Route("/edit/{id}", name="article_edit")
     */
    public function index($id = null, Request $request, PaginatorInterface $paginator): Response
    {
        $em = $this->getDoctrine()->getManager();
        if (is_null($id))
            $article = new Article();
        else
            $article = $em->find(Article::class, $id);

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($request->isMethod('POST') && $form->isValid()) {
            $user = $this->getUser();
            $article->setUser($user);

            $em->persist($article);
            $em->flush();
            $this->addFlash('success', "تمت العملية بنجاح");
            return $this->redirectToRoute("article_new");
        }
        $search= new ArticleSearch();
        $search->page = $request->get('page', 1);
        $form_search = $this->createForm(ArticleSearchType::class, $search);
        $form_search->handleRequest($request);
        if ($form_search->isSubmitted()) {
           // $id_user = $this->getUser()->getId();
            $articles = $em->getRepository(Article::class)->findSearch($search);
             //dump($articles);die();
        }
        else
            $articles = $paginator->paginate(

                $result = $em->getRepository(Article::class)->getArticleByUser($this->getUser()->getId()),

                $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                10 // Nombre de résultats par page
            );
      /* $articles = $em->getRepository(Article::class)
                ->getArticleByUser($this->getUser()->getId()); */
               // dump($articles);die();
         return $this->render('article/article.html.twig', array(
            'form' => $form->createView(),
            'articles' => $articles,
            'form_search' => $form_search->createView(),
            // 'sousMenu' => array(['nom' => 'المواد', 'url' => 'article_new'])
            //'categories'=> $categories,
        ));
    }
    /**
     * @Route("/delete/article/{id}", name="article_delete")
     *
     */
    public function deleteArticle(Article $id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        $this->addFlash('success', "تم الحذف بنجاح");
        return $this->redirectToRoute('article_new');
    }
    /**
     * @Route("/search", name="article_search")
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
            // dump($categorie);die();
            
                
            return $this->redirectToRoute('pdf1',[
                'categorie'=> $categorie->getId(),
                'type'=> $type->getId()
            ]);
        }
        $articles = $em->getRepository(Article::class)->findSearch($search);
        // dump($articles);die();

        return $this->render('article/pdf.html.twig', array(
          //  'form' => $form->createView(),
            'articles' => $articles,
            'form_search' => $form_search->createView(),
        ));
    }

    /**
    * @Route("/pdf1/categorie/{categorie}/type/{type}", name="pdf1")
    * @return response
    */
        public function pdf1Action($categorie, $type)
        {
           // dump($articles);die();
            $articles = $this->getDoctrine()
                            ->getRepository(Article::class)->getArticles($categorie, $type);
            $template = $this->renderView('pdf/pdf.html.twig', [
                'articles'=> $articles,
                'title' =>"قائمة المواد",
                ]);

            // Create an instance of the class:
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->SetDirectionality('rtl');
            $mpdf = new \Mpdf\Mpdf([
                'default_font_size' => 12,
                'default_font' => 'lateef'
            ]);
            // Write some HTML code:
           // $mpdf->SetHTMLFooter($footer);
            $mpdf->WriteHTML($template);
            // Output a PDF file directly to the browser
            $mpdf->Output();
        }




}