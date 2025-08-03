<?php

namespace App\Form;

use App\Entity\Sweatshirt;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class SweatshirtType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['class'=>'form-control'],
            ])
            ->add('price', NumberType::class, [
                'attr' => ['class'=>'form-control'],
            ])
            ->add('top', CheckboxType::class, [
                'label' => 'Mettre en avant',
                'required' => false,
                'attr' => ['class' => 'form-check-input'],
                'label_attr' => ['class' => 'form-check-label'],
                'row_attr' => ['class' => 'form-check']
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control'],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sweatshirt::class,
        ]);
    }
}
