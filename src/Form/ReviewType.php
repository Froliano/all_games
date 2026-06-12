<?php

namespace App\Form;

use App\Entity\Review;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('comment', TextareaType::class, [
                'required' => false,
                'label' => 'Your review',
                'attr' => [
                    'class' => 'w-full bg-gray-800 rounded border border-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-900 text-base outline-none text-gray-100 py-1 px-3 leading-8',
                    'rows' => 4,
                ],
                'label_attr' => [
                    'class' => 'leading-7 text-sm text-gray-400',
                ],
            ])
            ->add('review', ChoiceType::class, [
                'label' => 'Do you recommend this game?',
                'choices' => [
                    'Yes' => true,
                    'No' => false,
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotNull(),
                ],
                'label_attr' => [
                    'class' => 'leading-7 text-sm text-gray-400',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}
