<?php

namespace App\Form;

use App\Entity\Benificiaire;
use App\Entity\Fonction;
use App\Repository\FonctionRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class BenificiaireType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('benificiaire')
            ->add('remarque')
          //  ->add('fonction')
        ;
        $user = $this->security->getUser();

        /* if (!$user) {
             throw new \LogicException(
                 'The ArticleType cannot be used without an authenticated user!'
             );
         }*/

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($user) {
            $form = $event->getForm();
            $form->add('fonction', EntityType::class, [
                'class' => Fonction::class,
                'query_builder' => function (FonctionRepository $fonctionRepository)use ($user) {
                    return $fonctionRepository->findByCurrentUser($user);
                },
            ]);
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Benificiaire::class,
        ]);
    }
}
