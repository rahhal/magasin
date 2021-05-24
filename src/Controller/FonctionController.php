<?php

namespace App\Controller;

use App\Entity\Fonction;
use App\Form\FonctionType;
use App\Repository\FonctionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/fonction")
 * @IsGranted("ROLE_ENTREPRISE", message="ليس لديك الحق في الدخول الى هذه الصفحةّ")
 */
class FonctionController extends AbstractController
{
    /**
     * @Route("/", name="fonction_new")
     * @Route("/edit/{id}", name="fonction_edit")
     */

    public function index($id = null, Request $request, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        if (is_null($id))
            $fonction = new Fonction();
        else
            $fonction = $em->find(Fonction::class, $id);

        $form = $this->createForm(FonctionType::class, $fonction);
        $form->handleRequest($request);
        if ($request->isMethod('POST') && $form->isValid()) {
            $user = $this->getUser();
            $fonction->setUser($user);

            $em->persist($fonction);
            $em->flush();

            $this->addFlash('success', "تمت العملية بنجاح");
            return $this->redirectToRoute("fonction_new");
        }

        $fonctions = $paginator->paginate(
        //$result, // Requête contenant les données à paginer (ici nos categories)
            $result = $em->getRepository(Fonction::class)
                        ->findFonctionByUser($this->getUser()->getId()),
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            10 // Nombre de résultats par page
        );
        return $this->render('fonction/fonction.html.twig', array(
            'form' => $form->createView(),
            'fonctions' => $fonctions,
            // 'sousMenu' => array(['nom' => 'المواد', 'url' => 'fonction_new'])

        ));
    }
    /**
     * @Route("/delete/fonction/{id}", name="fonction_delete")
     *
     */
    public function deleteFonction(Fonction $id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        $this->addFlash('success', "تم الحذف بنجاح");
        return $this->redirectToRoute('fonction_new');
    }
}