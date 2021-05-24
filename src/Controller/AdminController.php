<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AdminType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route ("/admin")
 * @IsGranted("ROLE_SUPER_ADMIN", message="ليس لديك الحق في الدخول الى هذه الصفحةّ")
 * *
 */
class AdminController extends AbstractController
{
    /**
     * Admin.
     * @Route("/", name="admin_list")
     */

    public function admin()
    {
        $em= $this->getDoctrine()->getManager();
        // dump($users);die;
        $admin= $em->getRepository(User::class)->findByRole('ROLE_SUPER_ADMIN');

        return $this->render('admin/admin_list.html.twig', [
            'admins'=>$admin,
        ]);
    }

    /**
     * New Admin.
     *
     * @Route("/new", name="admin_new")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAdmin(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $em= $this->getDoctrine()->getManager();
        $user = new User();
        $form = $this->createForm(AdminType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //  Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $user->setRoles(['ROLE_SUPER_ADMIN']);

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', "تمت اضافة ادمين بنجاح");

            return $this->redirect($this->generateUrl('admin_list'));
        }

        return $this->render('admin/new_admin.html.twig', [
            'form' => $form->createView()
        ]);
    }

     /** modifier admin
     * @Route("/edit/{id}", name="admin_edit")
     */

    public function editAdminAction(Request $request, $id, UserPasswordEncoderInterface $passwordEncoder)
    {
        $em= $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);
        // dump($users),die;
        $form = $this->createForm(AdminType::class, $user);
        $formView = $form->createView();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $em->persist($user);
            $em->flush();
            $this->addFlash('success', "تم تغيير بيانات الادمين بنجاح");

            return $this->redirect($this->generateUrl('admin_list'));
        }

        return $this->render('admin/edit_admin.html.twig', [
            'form' => $formView,
            'user' => $user,
        ]);

    }
    /** show admin
     * @Route("/show/{id}", name="admin_show")
     */
    public function showAdminAction($id)
    {
        $em= $this->getDoctrine()->getManager();
        $admin = $em->getRepository(User::class)->find($id);
        // dump($users);
        //die;
        return $this->render('admin/show_admin.html.twig', [
            'admin' => $admin,
        ]);
    }
    /** delete admin
     * @Route("/delete/{id}", name="admin_delete")
     */
    public function deletAdmineAction(Request $request, $id)
    {
        $em= $this->getDoctrine()->getManager();
        $admin = $em->getRepository(User::class)->find($id);
        // dump($user),die;
        if($admin) {
            $em->remove($admin);
            $em->flush();
            $this->addFlash('success', "تمت الاضافة بنجاح");

            return $this->redirect($this->generateUrl('admin_list'));
        }
    }
}
