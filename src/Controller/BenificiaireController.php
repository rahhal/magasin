<?php

namespace App\Controller;

use App\Entity\Benificiaire;
use App\Form\BenificiaireType;
use App\Repository\BenificiaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/benificiaire")
 * @IsGranted("ROLE_ENTREPRISE", message="ليس لديك الحق في الدخول الى هذه الصفحةّ")
 */
class BenificiaireController extends AbstractController
{
    /**
     * @Route("/", name="benificiaire_new")
     * @Route("/edit/{id}", name="benificiaire_edit")
     */
    public function index($id = null, Request $request, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        if (is_null($id))
            $benificiaire = new Benificiaire();
        else
            $benificiaire = $em->find(Benificiaire::class, $id);

        $form = $this->createForm(BenificiaireType::class, $benificiaire);
        $form->handleRequest($request);
        if ($request->isMethod('POST') && $form->isValid()) {

            $user = $this->getUser();
            $benificiaire->setUser($user);

            $em->persist($benificiaire);
            $em->flush();

            $this->addFlash('success', "تمت العملية بنجاح");
            return $this->redirectToRoute("benificiaire_new");
        }
        $benificiaires = $paginator->paginate(
            $result = $em->getRepository(Benificiaire::class)
                ->getBenificiaireByUser($this->getUser()->getId()), // Requête contenant les données à paginer (ici nos annees)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            10 // Nombre de résultats par page
        );
        // $benificiaires = $em->getRepository(Benificiaire::class)->findAll();
        return $this->render('benificiaire/benificiaire.html.twig', array(
            'form' => $form->createView(),
            'benificiaires' => $benificiaires,
            // 'sousMenu' => array(['nom' => 'المواد', 'url' => 'fonction_new'])

        ));
    }

    /**
     * @Route("/delete/benificiaire/{id}", name="benificiaire_delete")
     *
     */
    public function deleteBenificiaire(Benificiaire $id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        $this->addFlash('success', "تم الحذف بنجاح");
        return $this->redirectToRoute('benificiaire_new');
    }
}
