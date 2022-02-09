<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled' => true
            ])
           
            ->add('lastname', TextType::class, [
                'disabled' => true,
                'label' => 'Nom'
            ])

            ->add('firstname', TextType::class, [
                'disabled' => true,
                'label' => 'Prénom'
            ])
            
            ->add('old_password', PasswordType::class,[
                'label' => 'Mot de Passe actuel',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre mot de passe actuel '
                ]
            ])

            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'le mot de passe et la confiramtion doivent être identiques',
                'label' => 'votre nouveau mot de Passe',
                'required' => true,
                'constraints' => new Length([
                    'min' => 6,
                    'max' => 15
                ]),
                'first_options' =>[
                    'label' => 'Votre nouveau mot de passe',
                    'attr' =>[
                        'placeholder' =>'Saisir votre nouveau mot de passe'
                    ]
                ],
                'second_options' =>[
                    'label' => 'Confirmez votre nouveau mot de passe',
                    'attr' =>[
                        'placeholder' =>'Confirmez votre nouveau mot de passe'
                    ]
                ]
            ])

            ->add('submit', SubmitType::class, [
                'label' => "Mettre à jour"
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
