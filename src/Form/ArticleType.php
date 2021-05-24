<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Type;
use App\Repository\CategorieRepository;
use App\Repository\TypeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ArticleType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libele',TextType::class, array('label' => 'Libele ar', 'required' =>true))
            /* ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'multiple' => false,
                //'attr' => array('placeholder' => ' اختر الصنف  ')
            ]) */
           // ->add('type')
            ->add('qte_min',IntegerType::class, array('label' => 'Qte min', 'required' =>true))
            ->add('qte_ini',IntegerType::class, array('label' => 'Qte ini', 'required' =>true))
            ->add('remarque',TextType::class, array('label' => 'Remarque', 'required' =>false))
        ;
        $user = $this->security->getUser();

       /* if (!$user) {
            throw new \LogicException(
                'The ArticleType cannot be used without an authenticated user!'
            );
        }*/

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($user) {
            $form = $event->getForm();
            $form->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'query_builder' => function (CategorieRepository $categorieRepository)use ($user) {
                    return $categorieRepository->findByCurrentUser($user);
                },
            ]);
        });
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($user) {
            $form = $event->getForm();
            $form->add('type', EntityType::class, [
                'class' => Type::class,
                'query_builder' => function (TypeRepository $typeRepository)use ($user) {
                    return $typeRepository->findByCurrentUser($user);
                },
            ]);
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
