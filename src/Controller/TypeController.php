<?php

namespace App\Controller;

use App\Entity\Type;
use App\Form\TypeType;
use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/type")
 * @IsGranted("ROLE_ENTREPRISE", message="ليس لديك الحق في الدخول الى هذه الصفحةّ")
 */
class TypeController extends AbstractController
{
    /**
     * @Route("/", name="type_new")
     * @Route("/edit/{id}", name="type_edit")
     */
    public function type($id = null, Request $request, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        if (is_null($id))
            $type = new Type();

        else
            $type = $em->find(Type::class, $id);

        $form = $this->createForm(TypeType::class, $type);
        $form->handleRequest($request);
        if ($request->isMethod('POST') && $form->isValid()) {
            $user = $this->getUser();
            $type->setUser($user);
            
        //dump($user);die();

            $em->persist($type);
            $em->flush();

            $this->addFlash('success', "تمت العملية بنجاح");
            return $this->redirectToRoute("type_new");
        }
       /*  if ($request->query->get('search')) {
            $query = $em->createQuery('SELECT ac FROM App:Categorie c WHERE  c.designation LIKE :search')
               ->setParameter('search', $request->query->get('search'));
           $result = $query->getResult();
       } else {
           $result = $em->getRepository(Categorie::class)->findAll();
       } */

        $types = $paginator->paginate(
            //$result, // Requête contenant les données à paginer (ici nos categories)
         $result = $em->getRepository(Type::class)->findAll(),
            // $result = $em->getRepository(Type::class)
            //              ->findTypeByUser($this->getUser()->getId()),

            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            10 // Nombre de résultats par page
        );


       // $categories = $em->getRepository(Categorie::class)->findAll();
        return $this->render('type/type.html.twig', array(
            'form' => $form->createView(),
            'types' => $types,
            // 'sousMenu' => array(['nom' => 'المواد', 'url' => 'article_new'])

        ));
    }


    /**
     * @Route("/delete/type/{id}", name="type_delete")
     */
    public function delete( Type $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        $this->addFlash('success', "تم الحذف بنجاح");

        return $this->redirectToRoute('type_new');
    }
}