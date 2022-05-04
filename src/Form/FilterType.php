<?php

namespace App\Form;

use App\Entity\Card;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('valueOrder', ChoiceType::class, [
            'choices' => [
                'Croissant' => true,
                'Décroissant' => false
            ],
            'mapped' => false,
            'attr' => ['class' => 'form-control'],
            'required' => false
        ])
        ->add('send', SubmitType::class, [
            'attr' => ['class' => 'btn btn-primary w-100 mt-3   ']
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
