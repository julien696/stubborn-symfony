<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class SweatshirtSizeStockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach (['XS', 'S', 'M', 'L', 'XL'] as $label) {
            $builder->add($label, IntegerType::class, [
                'required' => false,
                'label' => $label,
                'attr' => ['class'=>'form-control']
            ]);
        }
    }
}