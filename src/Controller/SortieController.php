<?php

namespace App\Controller;

use App\Entity\LigneEntree;
use App\Entity\LigneSortie;
use App\Entity\Societe;
use App\Entity\Sortie;
use App\Entity\Stock;
use App\Form\SortieType;
use App\Form\LigneSortieType;
use App\Repository\SortieRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/sortie")
 * @IsGranted("ROLE_ENTREPRISE", message="ليس لديك الحق في الدخول الى هذه الصفحةّ")
 */
class SortieController extends AbstractController
{
    /**
     * @Route("/index", name="sortie_index", methods={"GET"})
     */
    public function index(SortieRepository $sortieRepository): Response
    {
        return $this->render('sortie/index.html.twig', [
            'sorties' => $sortieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/", name="sortie_new", methods={"GET","POST"})
     * @Route("/edit/{id}", name="sortie_edit", methods={"GET","POST"})
     */
    public function new($id = null, Request $request, PaginatorInterface $paginator): Response

    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        if(is_null($id))
        {
        $sortie = new Sortie();
    }
    else
    {   $sortie = $em->find(Sortie::class, $id);
    }
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $sortie->setUser($user);

            $em->persist($sortie);
            $em->flush();

            return $this->redirectToRoute('sortie_show',['id' => $sortie->getId()]);
        }
        $sorties = $paginator->paginate(
            $result = $em->getRepository(Sortie::class)
                ->getSortieByUser($user->getId()), // Requête contenant les données à paginer (ici nos annees)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            10 // Nombre de résultats par page
        );        return $this->render('sortie/new.html.twig', [
            'sorties' => $sorties,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sortie_show", methods={"GET", "POST"})
     */
    public function show( Sortie $sortie, Request $request, PaginatorInterface $paginator): Response
    {$user= $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $ligneSortie = new LigneSortie();
        $form = $this->createForm(LigneSortieType::class, $ligneSortie);
        $form->handleRequest($request);
        if ($request->isMethod('POST') && $form->isValid()) {
            $ligneSortie->setSortie($sortie);
                           /* **************************** */
         //   foreach ($sortie->getLigneSorties() as $ligneSortie) {

                // find Line Purchase By Article: mise à jour du stock
                /*$repositoryLigneEntree = $this->getDoctrine()->getRepository(LigneEntree::class);
                $repositoryStock = $this->getDoctrine()->getRepository(Stock::class);
                $findLigneEntreeByArticle = $repositoryLigneEntree->findOneBy(['article' => $ligneSortie->getArticle()]);
                $findStockByLigneEntree = $repositoryStock->findOneBy(['ligne_entree' => $findLigneEntreeByArticle]);*/
            $repositoryStock = $this->getDoctrine()->getRepository(Stock::class);

            $findStockByLigneEntree = $repositoryStock
                ->findOneBy(['article' => $ligneSortie->getArticle()]);

            //  dump($findStockByLigneEntree);die();
                if ($findStockByLigneEntree) {
                  /* $old_quantity = $findStockByLigneEntree->getQte();
                   // $old_quantity = 22;

                    // $new_quantity = $ligneSortie->getQte();
                    $findStockByLigneEntree->setQte($old_quantity - $ligneSortie->getQte());
                    $findStockByLigneEntree->setQteReste($old_quantity);*/

                    $old_quantity = $findStockByLigneEntree->getQte();
                    $quantity = $ligneSortie->getQte();
                    $etat = $old_quantity - $quantity;
                    if ($etat < 0) {
//                            if ($etat < $findLineStockByLinePurchase->getQuantityAlerte())

                        $this->addFlash(
                            'danger',
                            '   الكمية المتوفرة بالمخزون من مادة: ' . $ligneSortie->getArticle()->getLibele() . ' تقدر بـ:  ' . $old_quantity . ' ،لا يمكنك القيام بهذا الخروج  ');
                        return $this->redirectToRoute("sortie_show", ['id' => $sortie->getId()]);
                    } else {



                    $old_quantity = $findStockByLigneEntree->getQteReste();

                    $findStockByLigneEntree->setQteReste($old_quantity - $ligneSortie->getQte());
                    $findStockByLigneEntree->setQte($old_quantity);

                    $findStockByLigneEntree->setArticle($ligneSortie->getArticle());
                    $findStockByLigneEntree->setDate(new \DateTime('now'));
                   // $findStockByLigneEntree->setUser($user->getId());

                    $ligneSortie->addStock($findStockByLigneEntree);
                    $em->flush();
                }
//            if ($findLineStockByLinePurchase) {
//                $old_quantity = $findLineStockByLinePurchase->getQtyUpdate();
//                $new_quantity = $lineExitt->getQuantity();
//                $findLineStockByLinePurchase->setQtyUpdate($old_quantity-$new_quantity);
//                $findLineStockByLinePurchase->setOldQty($old_quantity);
//                $em->flush();
//            }
           }

          //  $em->persist($findStockByLigneEntree);

            $em->persist($ligneSortie);
            $em->persist($sortie);
            $em->flush();
            $this->addFlash('success', "تمت العملية بنجاح");
            //  dump($ligneEntree);die();
            return $this->redirectToRoute("sortie_show", ['id' => $sortie->getId()]);
            // return $this->redirectToRoute("entree_show", ['id'=> $ligneEntree->getEntree()->getId()]);
        }
        $ligneSorties = $paginator->paginate(
            $result = $em->getRepository(LigneSortie::class)
                ->findLigneSortieBySortie($sortie->getId()), // Requête contenant les données à paginer (ici nos annees)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            10 // Nombre de résultats par page
        );
        //$ligneSorties = $em->getRepository(LigneSortie::class)->findAll();
        return $this->render('sortie/show.html.twig', [
            'sortie' => $sortie,
            'ligne_sorties' => $ligneSorties,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sortie_editt", methods={"GET","POST"})
     */
    public function edit(Request $request, Sortie $sortie): Response
    {
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sortie_index');
        }

        return $this->render('sortie/edit.html.twig', [
            'sortie' => $sortie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sortie_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Sortie $sortie): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sortie->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sortie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sortie_new');
    }
    /**
     * @Route("/{id}/pdf", name="sortie_pdf")
     */
    public function pdf($id = null)
    {$user= $this->getUser();
        $sorties = $this->getDoctrine()
            ->getRepository(Sortie::class)
            ->myFindOne($id);

        $ligneSortie=$this->getDoctrine()
            ->getRepository(LigneSortie::class)
            ->findLigneSortieBySortie($id);
        // dump($ligneSortie);die();
        $societe=$this->getDoctrine()
            ->getRepository(Societe::class)
            ->findSocieteByUser($user->getId());
        $html = $this->renderView('pdf/sortie.html.twig', array(
            'sorties' => $sorties,
            'ligne_sorties' => $ligneSortie,
            'title' =>"وصل خروج",
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
