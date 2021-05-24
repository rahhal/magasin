<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Knp\Component\Pager\PaginatorInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/categorie")
 * @IsGranted("ROLE_ENTREPRISE", message="ليس لديك الحق في الدخول الى هذه الصفحةّ")
 *
 */
class CategorieController extends AbstractController
{
    /**
     * @Route("/", name="categorie_new")
     * @Route("/edit/{id}", name="categorie_edit")
     */
    public function categorie($id = null, Request $request, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        if (is_null($id))
            $categorie = new Categorie();
        else
            $categorie = $em->find(Categorie::class, $id);

        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($request->isMethod('POST') && $form->isValid()) {
            $user = $this->getUser();
            $categorie->setUser($user);

            $em->persist($categorie);
            $em->flush();

            $this->addFlash('success', "تمت العملية بنجاح");
            return $this->redirectToRoute("categorie_new");
        }

        $categories = $paginator->paginate(
            $result = $em->getRepository(Categorie::class)
                   ->findCategorieByUser($this->getUser()->getId()),// Requête contenant les données à paginer (ici nos categories)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            10 // Nombre de résultats par page
        );
        return $this->render('categorie/categorie.html.twig', array(
            'form' => $form->createView(),
            'categories' => $categories,
            // 'sousMenu' => array(['nom' => 'المواد', 'url' => 'article_new'])

        ));
    }

    /**
     * @Route("/delete/categorie/{id}", name="categorie_delete")
     */
    public function delete( Categorie $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        $this->addFlash('success', "تم الحذف بنجاح");

        return $this->redirectToRoute('categorie_new');
    }

}
