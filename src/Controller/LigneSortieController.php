<?php

namespace App\Controller;

use App\Entity\LigneSortie;
use App\Form\LigneSortieType;
use App\Repository\LigneSortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/ligne/sortie")
 * @IsGranted("ROLE_ENTREPRISE", message="ليس لديك الحق في الدخول الى هذه الصفحةّ")
 */
class LigneSortieController extends AbstractController
{
    /**
     * @Route("/", name="ligne_sortie_index", methods={"GET"})
     */
    public function index(LigneSortieRepository $ligneSortieRepository): Response
    {
        return $this->render('ligne_sortie/index.html.twig', [
            'ligne_sorties' => $ligneSortieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="ligne_sortie_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $ligneSortie = new LigneSortie();
        $form = $this->createForm(LigneSortieType::class, $ligneSortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ligneSortie);
            $entityManager->flush();

            return $this->redirectToRoute('ligne_sortie_index');
        }

        return $this->render('ligne_sortie/new.html.twig', [
            'ligne_sortie' => $ligneSortie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ligne_sortie_show", methods={"GET"})
     */
    public function show(LigneSortie $ligneSortie): Response
    {
        return $this->render('ligne_sortie/show.html.twig', [
            'ligne_sortie' => $ligneSortie,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ligne_sortie_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, LigneSortie $ligneSortie): Response
    {
        $form = $this->createForm(LigneSortieType::class, $ligneSortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ligne_sortie_index');
        }

        return $this->render('ligne_sortie/edit.html.twig', [
            'ligne_sortie' => $ligneSortie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ligne_sortie_delete", methods={"DELETE"})
     */
    public function delete(Request $request, LigneSortie $ligneSortie): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ligneSortie->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ligneSortie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ligne_sortie_index');
    }
}
