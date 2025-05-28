<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('color', ChoiceType::class, [
                'label' => 'Color',
                'choices' => [
                    'Red' => 'red',
                    'Green' => 'green',
                    'Gray' => 'gray',
                    'Blue' => 'blue',
                    'Indigo' => 'indigo'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('order', IntegerType::class, [
                'label' => 'Order',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
} 