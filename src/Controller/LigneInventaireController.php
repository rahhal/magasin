<?php

namespace App\Controller;

use App\Entity\LigneInventaire;
use App\Form\LigneInventaireType;
use App\Repository\LigneInventaireRepository;
use App\Repository\StockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// Include JSON Response
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/ligne/inventaire")
 * @IsGranted("ROLE_ENTREPRISE", message="ليس لديك الحق في الدخول الى هذه الصفحةّ")
 */
class LigneInventaireController extends AbstractController
{
    /**
     * @Route("/", name="ligne_inventaire_index", methods={"GET"})
     */
    public function index(LigneInventaireRepository $ligneInventaireRepository, LigneInventaire $ligneInventaire): Response
    {
        $ligneInventaires= $ligneInventaireRepository->myLigneInventaire($ligneInventaire->getInventaire()->getId());
        //$ligneEntree->getEntree()->getId()
        return $this->render('ligne_inventaire/index.html.twig', [
            'ligne_inventaires' =>  $ligneInventaires
           // 'ligne_inventaires' =>  $ligneInventaireRepository->findAll()
        ]);
    }

    /**
     * @Route("/new", name="ligne_inventaire_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $ligneInventaire = new LigneInventaire();
        $form = $this->createForm(LigneInventaireType::class, $ligneInventaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ligneInventaire);
            $entityManager->flush();

            return $this->redirectToRoute('ligne_inventaire_index');
        }

        return $this->render('ligne_inventaire/new.html.twig', [
            'ligne_inventaire' => $ligneInventaire,
            'form' => $form->createView(),
        ]);
    }
    /**
     * Returns a JSON string with the stocks of the article with the providen id.
     * @Route("/listStocksOfArticle", name="ligne_inventaire_list_stocks", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */

    public function listStocksOfArticleAction(Request $request, StockRepository $stockRepository)
    {
                // Search the stocks that belongs to the aricle with the given id as GET parameter "articleid"
              /*  $stocks = $stockRepository->createQueryBuilder("q")
                    ->where("q.article = :articleid")
                    ->setParameter("articleid", $request->query->get("articleid"))
                    ->getQuery()
                    ->getResult();*/
        $stocks = $stockRepository->findByArticle($request->query->get("articleid"));
                // Serialize into an array the data that we need, in this case only qte and id
                // Note: you can use a serializer as well, for explanation purposes, we'll do it manually
                $responseArray = array();
                foreach($stocks as $stock){
                                                $responseArray[] = array(
                                                    "id" => $stock->getId(),
                                                    "qte" => $stock->getQteReste()
                                                );
                                            }

                // Return array with structure of the stocks of the providen article id
                return new JsonResponse($responseArray);

                // e.g
                // [{"id":"3","qte":"50"}]
    }
    /**
     * @Route("/{id}", name="ligne_inventaire_show", methods={"GET"})
     */
    public function show(LigneInventaire $ligneInventaire): Response
    {
        return $this->render('ligne_inventaire/show.html.twig', [
            'ligne_inventaire' => $ligneInventaire,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ligne_inventaire_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, LigneInventaire $ligneInventaire): Response
    {
        $form = $this->createForm(LigneInventaireType::class, $ligneInventaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

           // return $this->redirectToRoute('ligne_inventaire_index');
           // return $this->redirectToRoute("inventaire_show", ['id' => $inventaire->getId()]);
             return $this->redirectToRoute("inventaire_show", ['id'=> $ligneInventaire->getInventaire()->getId()]);
        }

        return $this->render('ligne_inventaire/edit.html.twig', [
            'ligne_inventaire' => $ligneInventaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ligne_inventaire_delete", methods={"DELETE"})
     */
    public function delete(Request $request, LigneInventaire $ligneInventaire): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ligneInventaire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ligneInventaire);
            $entityManager->flush();
        }

       // return $this->redirectToRoute('ligne_inventaire_index');
        return $this->redirectToRoute("inventaire_show", ['id'=> $ligneInventaire->getInventaire()->getId()]);

    }


    
}
