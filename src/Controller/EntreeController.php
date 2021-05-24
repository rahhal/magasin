<?php

namespace App\Controller;

use App\Entity\Entree;
use App\Entity\LigneEntree;
use App\Entity\Societe;
use App\Entity\Stock;
use App\Form\EntreeType;
use App\Form\LigneEntreeType;
use App\Repository\EntreeRepository;
use App\Repository\StockRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/entree")
 * @IsGranted("ROLE_ENTREPRISE", message="ليس لديك الحق في الدخول الى هذه الصفحةّ")
 */
class EntreeController extends AbstractController
{
    /**
     * @Route("/index", name="entree_index", methods={"GET"})
     */
    public function index(EntreeRepository $entreeRepository): Response
    {
        return $this->render('entree/index.html.twig', [
            'entrees' => $entreeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/ajout", name="entree_ajout", methods={"GET","POST"})
     */
    public function ajout(Request $request): Response
    {
        $entree = new Entree();
        $form = $this->createForm(EntreeType::class, $entree);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entree);
            $entityManager->flush();

            return $this->redirectToRoute('entree_index');
        }

        return $this->render('entree/new.html.twig', [
            'entree' => $entree,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/", name="entree_new")
     * @Route("/edit/{id}", name="entree_edit")
     *
     */
    public function new($id = null, Request $request, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        if (is_null($id))
            $entree = new Entree();
        else
            $entree = $em->find(Entree::class, $id);

        $form = $this->createForm(EntreeType::class, $entree);
        $form->handleRequest($request);
        if ($request->isMethod('POST') && $form->isValid()) {
            $user = $this->getUser();
            $entree->setUser($user);

            $em->persist($entree);
            $em->flush();

            $this->addFlash('success', "تمت العملية بنجاح");
            return $this->redirectToRoute("entree_show", ['id'=> $entree->getId()]);
        }
        $entrees = $paginator->paginate(
            $result = $em->getRepository(Entree::class)
                ->getEntreeByUser($this->getUser()->getId()), // Requête contenant les données à paginer (ici nos annees)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            10 // Nombre de résultats par page
        );
        return $this->render('entree/new.html.twig', array(
            'form' => $form->createView(),
            'entrees' => $entrees,
            // 'sousMenu' => array(['nom' => 'المواد', 'url' => 'article_new'])

        ));
    }

    /**
     * @Route("/{id}", name="entree_show", methods={"GET", "POST"})
     */
    public function show( Entree $entree, Request $request, PaginatorInterface $paginator): Response
    {
        $em = $this->getDoctrine()->getManager();
        $ligneEntree = new LigneEntree();
        $form = $this->createForm(LigneEntreeType::class, $ligneEntree);
        $form->handleRequest($request);


        if ($request->isMethod('POST') && $form->isValid()) {
            $user = $this->getUser();
            $entree->setUser($user);

            $ligneEntree->setEntree($entree);

            /**** renvoi des données au Stock */

          //  foreach ($entree->getLigneEntrees() as $ligneEntree) {
               // $repositoryLigneEntree = $this->getDoctrine()->getRepository(LigneEntree::class);
               // $findLigneEntreeByArticle = $repositoryLigneEntree->findOneBy(['article' => $ligneEntree->getArticle()]);
                $repositoryStock = $this->getDoctrine()->getRepository(Stock::class);
                 // $myStock = $repositoryStock->findOneBy(['ligne_entree' => $ligneEntree]);
            $myStock = $repositoryStock->findOneBy(['article' => $ligneEntree->getArticle()]);

            //  $myStock = $repositoryStock->findOneBy(['ligne_entree' => $findLigneEntreeByArticle]);
                //dump($myStock);die();
                if ($myStock) {
                    $old_quantity = $myStock->getQteReste();
                    // dump($old_quantity);die();
                    // $old_quantity = 666;
                    $new_quantity = $ligneEntree->getQteEntr();
                  // $myStock->setQte($old_quantity + $new_quantity);
                    $myStock->setQte($old_quantity);
                    $myStock->setQteReste($old_quantity + $new_quantity);
                    $myStock->setArticle($ligneEntree->getArticle());
                    $myStock->setDate(new \DateTime('now'));
                    $myStock->setLigneEntree($ligneEntree);
                    $myStock->setUser($user);
                    $em->persist($myStock);
               /*     $old_quantity = $myStock->getQteReste();
                    // dump($old_quantity);die();
                    // $old_quantity = 666;
                    $new_quantity = $ligneEntree->getQteEntr();

                    $myStock->setQteReste($old_quantity + $new_quantity);
                    $myStock->setQte($old_quantity);
                    $myStock->setArticle($ligneEntree->getArticle());
                    $myStock->setDate(new \DateTime('now'));
                    $myStock->setLigneEntree($ligneEntree);
                    $em->persist($myStock);*/
                    /* $myStock->setProduit('كتاب');
                     // $new_quantity = 22;
                     $myStock->setQte(22);
                     $myStock->setQteReste(11);
                     $myStock->setDate(new \DateTime('now'));
                     $myStock->setLigneEntree($ligneEntree);
                    $ligneEntree->setStock($myStock);*/
                    // dump($myStock);die();
                   // $em->flush();
                } else {
                     $stock = new Stock();
                    $stock->setLigneEntree($ligneEntree);
                    // $stock->setQte($ligneEntree->getQteEntr() );
                    $stock->setQte( $ligneEntree->getArticle()->getQteIni() );
                    $stock->setDate(new \DateTime('now'));
                    // $stock->setOldQty($linePurchase->getArticle()->getIniQty());
                    $stock->setArticle($ligneEntree->getArticle());
                   // $stock->setQteReste(12);
                    $stock->setQteReste($ligneEntree->getQteEntr()+ $ligneEntree->getArticle()->getQteIni());
                    $stock->setUser($user);
                    $em->persist($stock); 
                  
                }
                //}

                $em->persist($ligneEntree);
                $em->persist($entree);
                $em->flush();
                $this->addFlash('success', "تمت العملية بنجاح");
                //  dump($ligneEntree);die();
                return $this->redirectToRoute("entree_show", ['id' => $entree->getId()]);
                // return $this->redirectToRoute("entree_show", ['id'=> $ligneEntree->getEntree()->getId()]);
            }
            $ligneEntrees = $paginator->paginate(
                $result = $em->getRepository(LigneEntree::class)
                             ->findLigneEntreeByEntree($entree->getId()),
                $request->query->getInt('page', 1),
                10 // Nombre de résultats par page
            );
        return $this->render('entree/show.html.twig', [
            'entree' => $entree,
            'ligne_entrees' => $ligneEntrees,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/editt", name="entree_editt", methods={"GET","POST"})
     */
    public function edit(Request $request, Entree $entree): Response
    {
        $form = $this->createForm(EntreeType::class, $entree);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('entree_new');
        }

        return $this->render('entree/edit.html.twig', [
            'entree' => $entree,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="entree_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Entree $entree): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entree->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($entree);
            $entityManager->flush();
        }

        return $this->redirectToRoute('entree_index');
    }

    /**
     * @Route("/{id}/pdf", name="entree_pdf")
     */
        public function pdf($id = null)
    {
        $entrees = $this->getDoctrine()
            ->getRepository(Entree::class)
            ->myFindOne($id);

        $ligneEntree=$this->getDoctrine()
            ->getRepository(LigneEntree::class)
            ->findLigneEntreeByEntree($id);
       // dump($ligneEntree);die();
        $societe=$this->getDoctrine()
            ->getRepository(Societe::class)->findSocieteByUser($this->getUser()->getId());
        $html = $this->renderView('pdf/entree.html.twig', array(
            'entrees' => $entrees,
            'ligne_entrees' => $ligneEntree,
            'title' =>"وصل دخول",
            'societe'=> $societe,
        ));
//        $footer = $this->renderView('pdf/footer.html.twig', array(
//            'institution'=> $institution,
//        ));
        // Create an instance of the class:
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetDirectionality('rtl');
        // Write some HTML code:
        //$mpdf->SetHTMLFooter($footer);
        $mpdf->WriteHTML($html);
        // Output a PDF file directly to the browser
        $mpdf->Output();

    }
}
