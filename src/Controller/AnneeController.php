<?php

namespace App\Controller;

use App\Entity\Annee;
use App\Form\AnneeType;
use App\Repository\AnneeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/annee")
 * @IsGranted("ROLE_ENTREPRISE", message="ليس لديك الحق في الدخول الى هذه الصفحةّ")
 */
class AnneeController extends AbstractController
{
    /**
     * @Route("/", name="annee_new")
     * @Route("/edit/{id}", name="annee_edit")
     */
    public function annee($id = null, Request $request, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        if (is_null($id))
            $annee = new Annee();
        else
            $annee = $em->find(Annee::class, $id);

        $form = $this->createForm(AnneeType::class, $annee);
        $form->handleRequest($request);
        if ($request->isMethod('POST') && $form->isValid()) {
            $em->persist($annee);
            $em->flush();

            $this->addFlash('success', "تمت العملية بنجاح");
            return $this->redirectToRoute("annee_new");
        }

        $annees = $paginator->paginate(
            $result = $em->getRepository(Annee::class)->findAll(), // Requête contenant les données à paginer (ici nos annees)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            10 // Nombre de résultats par page
        );
        // $annees = $em->getRepository(Annee::class)->findAll();
        return $this->render('annee/annee.html.twig', array(
            'form' => $form->createView(),
            'annees' => $annees,
            // 'sousMenu' => array(['nom' => 'المواد', 'url' => 'article_new'])

        ));
    }

    /**
     * @Route("/show/{id}", name="annee_show", methods={"GET"})
     */
    public function show(Annee $annee): Response
    {
        return $this->render('annee/show.html.twig', [
            'annee' => $annee,
        ]);
    }

    /**
     * @Route("/{id}", name="annee_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Annee $annee, $id): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annee->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($annee);
            $entityManager->flush();
        }

        return $this->redirectToRoute('annee_new');
    }
        /*$em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('Annee')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Preisliste entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('annee_new')); */
   // }
        }