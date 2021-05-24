<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class Stock1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    { $builder
         ->remove('date')

        ->remove('qte')
        ->remove('qte_reste')
    ;

    }

    public function getParent()
    {
        return StockType::class;
    }
}
