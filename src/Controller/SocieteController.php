<?php

namespace App\Controller;

use App\Entity\Societe;
use App\Form\SocieteType;
use App\Repository\SocieteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/societe")
 */
class SocieteController extends AbstractController
{
    /**
     * @Route("/", name="societe_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ENTREPRISE", message="ليس لديك الحق في الدخول الى هذه الصفحةّ")
     */
    public function new(Request $request): Response
    {
        $societe = new Societe();
        $form = $this->createForm(SocieteType::class, $societe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $user = $this->getUser();
            $societe->setUser($user);
            $entityManager->persist($societe);
            $entityManager->flush();
            $this->addFlash('success', 'تمت الاضافة بنجاح ');

            return $this->redirectToRoute('societe_show');

        }

        return $this->render('societe/new.html.twig', [
            'societe' => $societe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="societe_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Societe $societe): Response
    {
        $form = $this->createForm(SocieteType::class, $societe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', "تم التغيير بنجاح");

            return $this->redirectToRoute('societe_show');
        }

        return $this->render('societe/edit.html.twig', [
            'societe' => $societe,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/show", name="societe_show", methods={"GET"})
     */
    public function show( ): Response
    {
        $em= $entityManager = $this->getDoctrine()->getManager();

        $em= $this->getDoctrine()->getManager();
        //$societe = $em->getRepository(Societe::class)->find($id);

        /*$societe = $em->getRepository(Societe::class)
                          ->findSocieteByUser($this->getUser()->getId());*/
        $societe = $entityManager->getRepository('App:Societe')
            ->findOneBy(['user' => $this->getUser()->getId()]);
        if ($societe)
            return $this->render('societe/show.html.twig', [
                'societe' => $societe,
            ]);
        else
            return $this->redirectToRoute('societe_new');

    }

}
