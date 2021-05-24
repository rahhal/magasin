<?php

namespace App\Controller;

use App\Entity\LigneEntree;
use App\Form\LigneEntreeType;
use App\Repository\LigneEntreeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/ligne/entree")
 * @IsGranted("ROLE_ENTREPRISE", message="ليس لديك الحق في الدخول الى هذه الصفحةّ")
 */
class LigneEntreeController extends AbstractController
{
    /**
     * @Route("/", name="ligne_entree_index", methods={"GET"})
     */
    public function index(LigneEntreeRepository $ligneEntreeRepository): Response
    {
        return $this->render('ligne_entree/index.html.twig', [
            'ligne_entrees' => $ligneEntreeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/new", name="ligne_entree_new", methods={"GET","POST"})
     */
    public function new(Request $request, $id): Response
    {    $entityManager = $this->getDoctrine()->getManager();
        $ligneEntree = new LigneEntree();
        $entree = $entityManager->getRepository('App:Entree')->find($id);
        $form = $this->createForm(LigneEntreeType::class, $ligneEntree);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ligneEntree);
            $ligneEntree->setEntree($entree);
            $entityManager->flush();

            //return $this->redirectToRoute('ligne_entree_index');
            return $this->redirectToRoute('entree_show', ['id', $entree->getId()  ]);
        }

        return $this->render('ligne_entree/new.html.twig', [
            'ligne_entrees' => $ligneEntree,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ligne_entree_show", methods={"GET"})
     */
    public function show(LigneEntree $ligneEntree): Response
    {
        return $this->render('ligne_entree/show.html.twig', [
            'ligne_entree' => $ligneEntree,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ligne_entree_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, LigneEntree $ligneEntree): Response
    {
        $form = $this->createForm(LigneEntreeType::class, $ligneEntree);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ligne_entree_index');
        }

        return $this->render('ligne_entree/edit.html.twig', [
            'ligne_entree' => $ligneEntree,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ligne_entree_delete", methods={"DELETE"})
     */
    public function delete(Request $request, LigneEntree $ligneEntree): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ligneEntree->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ligneEntree);
            $entityManager->flush();
        }

//        return $this->redirectToRoute('ligne_entree_index');
        return $this->redirectToRoute('entree_show', ['id', $ligneEntree->getEntree()->getId()  ]);

    }
}
