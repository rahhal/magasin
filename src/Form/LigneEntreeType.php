<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Entree;
use App\Entity\LigneEntree;
use App\Repository\ArticleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class LigneEntreeType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            /*->add('article', EntityType::class, [
                'class' => Article::class,
                'multiple' => false
            ])*/
            ->add('qte_entr')
            ->add('qte_reste',HiddenType::class,[
                'required' => false,
            ])
            //->add('article')
           /* ->add('entree',EntityType::class, [
                'class' => Entree::class,
                'multiple' => false
            ])*/
        ;
        $user = $this->security->getUser();
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($user) {
            $form = $event->getForm();
            $form->add('article', EntityType::class, [
                'class' => Article::class,
                'query_builder' => function (ArticleRepository $articleRepository)use ($user) {
                    return $articleRepository->findByCurrentUser($user);
                },
            ]);
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LigneEntree::class,
        ]);
    }
}
