<?php

namespace App\Form;

use App\Entity\SweatshirtSize;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\Model\AddToCartData;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class ChooseYourSizeForSweatwhirtType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $orderedSizes = $options['available_sizes'];
        $order = ['XS', 'S', 'M', 'L', 'XL'];

        usort($orderedSizes, function (SweatshirtSize $a, SweatshirtSize $b) use ($order) {
            $posA = array_search($a->getSize()->getLabel(), $order);
            $posB = array_search($b->getSize()->getLabel(), $order);
            return $posA <=> $posB;
        });

        $builder
            ->add('sweatshirtSize', EntityType::class,[
                'class' => SweatshirtSize::class,
                'choices' => $orderedSizes,
                'choice_label' => fn(SweatshirtSize $ss) => $ss->getSize()->getLabel(),
                'label' => 'size',
            ])
            ->add('quantity', IntegerType::class, [
                'label' => 'Quantity',
                'data' => 1,
                'attr' => ['min' => 1, 'max' => 2]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AddToCartData::class,
            'available_sizes' => []
        ]);
    }
}
