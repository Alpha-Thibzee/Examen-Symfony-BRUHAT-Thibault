<?php

namespace App\Form;

use App\Entity\Card;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name' , TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrer un nom pour la carte'
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Le nom de la carte doit contenir au moins {{ limit }} caractères.',
                        'max' => 70,
                        'maxMessage' => 'Le titre de la tache doit contenir au maximum {{ limit }} caractères.'
                    ])
                ]
            ])
            ->add('isOnSale' , CheckboxType::class , [
                'required' => false,
                'data_class' => null
            ])
            ->add('quantity' , IntegerType::class , [
                'attr' => ['min' => "1"],
                'data_class' => null
            ])
            ->add('value' ,IntegerType::class , [
                 'attr' => ['min' => "1"],
                 'data_class' => null
            ])
            ->add('picture' , FileType::class , [
                "required" => false,
                'mapped' => false,
                'data_class' => null,
                "constraints" => [
                        new Image([
                            "maxSize" => '1024k'
                        ])
                ]
            ])
            ->add('description', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Entrer une description pour la carte"
                    ]),
                    new Length([
                        'min' => 50,
                        'minMessage' => "La description de la carte doit contenir au moins {{ limit }} caractères.",
                       
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Card::class,
        ]);
    }
}
