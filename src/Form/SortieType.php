<?php

namespace App\Form;

use App\Entity\Benificiaire;
use App\Entity\Sortie;
use App\Repository\BenificiaireRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class SortieType extends AbstractType
{
    private
        $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date',DateType::class,  [
                'label' => 'التاريخ :',
                'required' => true,
                'widget' => 'single_text',
                //'html5' => false,
                // 'format' => 'dd/MM/yyyy',
                'attr' => ['class' => 'form-control pickadate-selectors',
                    'autocomplete' => 'off'
                ],
            ])
            ->add('bon_sortie')
            ->add('num')
            ->add('annee')
            //->add('benificiaire')
        ;
        $user = $this->security->getUser();

        /* if (!$user) {
             throw new \LogicException(
                 'The ArticleType cannot be used without an authenticated user!'
             );
         }*/

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($user) {
            $form = $event->getForm();
            $form->add('benificiaire', EntityType::class, [
                'class' => Benificiaire::class,
                'query_builder' => function (BenificiaireRepository $benificiaireRepository) use ($user) {
                    return $benificiaireRepository->findByCurrentUser($user);
                },
            ]);
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
