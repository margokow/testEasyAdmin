<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placehodler' => 'jean.dupont@gmail.com',
                    'minLength' => 2,
                    'maxLength' => 50
                ],
                'label' => 'Adresse e-mail',
                'label_attr' => [
                    'class' => 'form-label',
                    'style' => 'color : blue'   
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['min' =>2, 'max'=>50]),
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label'=> 'Accepter les termes',
                'label_attr'=>[
                    'class'=>'form-label',
                    'style'=>'color: blue'
                ],
                'constraints' => [
                    new IsTrue([
                        'message' => 'Voulez-vous accepter les termes ?',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                    'first_options' => [
                        'attr' => [
                            'class' => 'form-control',
                            'placeholder' => 'Mot de passe', 
                        ],
                        'label' => 'Mot de passe',
                        'label_attr' => [
                            'class' => 'form-label',
                            'style' => 'color : blue',
                        ],
                        'constraints' => [
                            new Assert\NotBlank([
                                'message' => "Veuillez entrer un mot de passe",
                            ]),
                            new Assert\Length([
                                'min' => 6,
                                'minMessage' => 'Votre message doit contenir au moins {{limit}} caractères',
                                'max' => 4096,
                            ]),
                            new Assert\Regex([
                                'pattern'=>'/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*]).{10,}$/',
                                'message'=>'Votre mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial'
                            ])
                            ],
                        'mapped' => false,
                    ],
                    'second_options' => [
                        'attr'=>[
                            'class'=>'form-control bg-white-secondary rouded-button border-none',
                            'placeholder'=> 'Confirmer votre mot de passe',
                        ],
                        'label'=>"Confirmation de votre mot de passe",
                        'label_attr'=>[
                            'class'=>'form-label',
                            'style'=>'color: blue'
                        ],
                        'constraints'=>[
                            new Assert\NotBlank([
                                'message'=>'Veuillez confirmer votre mot de passe'
                            ]),
                            new Assert\Length([
                                'min'=>6,
                                'minMessage'=>'Votre mot de passe doit contenir au moins 6 caractères',
                                'max'=>4096
                            ]),
                            new Assert\Regex([
                                'pattern'=>'/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*]).{10,}$/',
                                'message'=>'Votre mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial'
                            ]),
                        ],
                        'mapped'=>false,
                    ],
                    'invalid_message'=>"The passwords do not match"
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
