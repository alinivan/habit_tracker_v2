<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Habit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bundle\SecurityBundle\Security;

class HabitType extends AbstractType
{
    public function __construct(
        private readonly Security $security
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->security->getUser();

        $builder
            ->add('name', TextType::class, [
                'label' => 'Name',
                'attr' => ['class' => 'form-input'],
            ])
            ->add('minValue', NumberType::class, [
                'label' => 'Min value',
                'attr' => ['class' => 'form-input'],
            ])
            ->add('order', NumberType::class, [
                'label' => 'Order',
                'attr' => ['class' => 'form-input'],
            ])
            ->add('points', NumberType::class, [
                'label' => 'Points',
                'attr' => ['class' => 'form-input'],
            ])
            ->add('active', ChoiceType::class, [
                'label' => 'Active',
                'choices' => [
                    'Yes' => true,
                    'No' => false,
                ],
                'attr' => ['class' => 'form-select'],
            ])
            ->add('measurement', ChoiceType::class, [
                'label' => 'Measurement',
                'choices' => [
                    'Minutes' => 'min',
                    'Kilograms' => 'kg',
                ],
                'attr' => ['class' => 'form-select'],
            ])
            ->add('category', EntityType::class, [
                'label' => 'Category',
                'class' => Category::class,
                'choice_label' => 'name',
                'query_builder' => function ($repository) use ($user) {
                    return $repository->createQueryBuilder('c')
                        ->where('c.user = :user')
                        ->setParameter('user', $user)
                        ->orderBy('c.name', 'ASC');
                },
                'attr' => ['class' => 'form-select'],
            ])
            ->add('isProductive', ChoiceType::class, [
                'label' => 'Productive',
                'choices' => [
                    'Yes' => true,
                    'No' => false,
                ],
                'attr' => ['class' => 'form-select'],
            ])
            ->add('parent', EntityType::class, [
                'label' => 'Parent Habit',
                'class' => Habit::class,
                'choice_label' => 'name',
                'required' => false,
                'query_builder' => function ($repository) use ($user) {
                    return $repository->createQueryBuilder('h')
                        ->where('h.user = :user')
                        ->setParameter('user', $user)
                        ->orderBy('h.name', 'ASC');
                },
                'attr' => ['class' => 'form-select'],
            ])
            ->add('valueType', ChoiceType::class, [
                'label' => 'Type',
                'choices' => [
                    'Number' => 'number',
                    'Boolean' => 'boolean',
                ],
                'attr' => ['class' => 'form-select'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Habit::class,
        ]);
    }
} 