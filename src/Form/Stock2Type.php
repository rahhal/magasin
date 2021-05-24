<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class Stock2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    { $builder

        ->remove('article')
        ->remove('qte')
        ->remove('qte_reste')
    ;

    }

    public function getParent()
    {
        return StockType::class;
    }
}
