<?php

namespace App\Controller;

use App\Entity\Fournisseur;
use App\Form\FournisseurType;
use App\Repository\FournisseurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/fournisseur")
 * @IsGranted("ROLE_ENTREPRISE", message="ليس لديك الحق في الدخول الى هذه الصفحةّ")
 */
class FournisseurController extends AbstractController
{
    /**
     * @Route("/", name="fournisseur_new")
     * @Route("/edit/{id}", name="fournisseur_edit")
     *
     */
    public function index($id = null, Request $request, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        if (is_null($id))
            $fournisseur = new Fournisseur();
        else
            $fournisseur = $em->find(Fournisseur::class, $id);

        $form = $this->createForm(FournisseurType::class, $fournisseur);
        $form->handleRequest($request);
        if ($request->isMethod('POST') && $form->isValid()) {

            $user = $this->getUser();
            $fournisseur->setUser($user);

            $em->persist($fournisseur);
            $em->flush();

            $this->addFlash('success', "تمت العملية بنجاح");
            return $this->redirectToRoute("fournisseur_new");
        }
        $fournisseurs = $paginator->paginate(
            $result = $em->getRepository(Fournisseur::class)
                ->getFournisseurByUser($this->getUser()->getId()),// Requête contenant les données à paginer (ici nos categories)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            10 // Nombre de résultats par page
        );
        //$fournisseurs = $em->getRepository(Fournisseur::class)->findAll();
        return $this->render('fournisseur/fournisseur.html.twig', array(
            'form' => $form->createView(),
            'fournisseurs' => $fournisseurs,
            // 'sousMenu' => array(['nom' => 'المواد', 'url' => 'fournisseur_new'])

        ));
    }
    /**
     * @Route("/delete/fournisseur/{id}", name="fournisseur_delete")
     *
     */
    public function deleteFournisseur(Fournisseur $id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        $this->addFlash('success', "تم الحذف بنجاح");
        return $this->redirectToRoute('fournisseur_new');
    }

}
