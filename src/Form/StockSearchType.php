<?php

namespace App\Form;

use App\Entity\StockSearch;
use App\Entity\Categorie;
use App\Entity\Type;
use App\Repository\CategorieRepository;
use App\Repository\TypeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class StockSearchType extends AbstractType
{
    public $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->security->getUser();
        $builder->add('date',DateType::class,  [
            'label' => 'التاريخ :',
            'required' => true,
            'widget' => 'single_text',
            //'html5' => false,
            // 'format' => 'dd/MM/yyyy',
            'attr' => ['class' => 'form-control pickadate-selectors',
                'autocomplete' => 'off'
            ],
        ]);
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

    public function getBlockPrefix()
    {
        return ''; // TODO: Change the autogenerated stub
    }
}